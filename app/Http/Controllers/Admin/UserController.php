<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Entity;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use LdapRecord\Models\ActiveDirectory\User as LdapUser; // On importe le modèle User de l'AD

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('entities')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $entities = Entity::all();
        $applications = Application::orderBy('name')->get();

        $userEntityIds = $user->entities->pluck('id')->toArray();
        $userApplicationIds = $user->directApplications->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'entities', 'applications', 'userEntityIds', 'userApplicationIds'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'nullable',
            'entities' => 'nullable|array',
            'entities.*' => 'exists:entities,id',
            'applications' => 'nullable|array',
            'applications.*' => 'exists:applications,id',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $request->has('is_admin');
        $user->save();

        $user->entities()->sync($request->input('entities', []));
        $user->directApplications()->sync($request->input('applications', []));

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // On pourrait ajouter une vérification pour ne pas supprimer le dernier admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Vous не pouvez pas supprimer le dernier administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function importShow()
    {
        return view('admin.users.import');
    }

    public function importStore(Request $request)
    {
        $request->validate(['samaccountname' => 'required|string']);

        $samaccountname = $request->samaccountname;
        $ldapUser = LdapUser::where('samaccountname', '=', $samaccountname)->first();

        if (!$ldapUser) {
            return back()->with('error', "L'utilisateur avec le samaccountname '{$samaccountname}' n'a pas été trouvé dans l'Active Directory.")->withInput();
        }

        // On s'assure que l'utilisateur a bien les attributs nécessaires
        if ($ldapUser->getFirstAttribute('samaccountname')) {
            User::updateOrCreate(
                ['username' => $ldapUser->getFirstAttribute('samaccountname')],
                [
                    'name' => $ldapUser->getFirstAttribute('cn'),
                    'email' => $ldapUser->getFirstAttribute('mail'),
                    'guid' => $ldapUser->getConvertedGuid(),
                    'password' => Hash::make(Str::random(32)),
                ]
            );
        } else {
            return back()->with('error', "L'utilisateur trouvé n'a pas de samaccountname. Importation annulée.")->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', "L'utilisateur '{$samaccountname}' a été importé ou mis à jour avec succès.");
    }
}