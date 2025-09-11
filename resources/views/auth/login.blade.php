<x-guest-layout>
    <style>
        /* CSS pour notre personnage interactif */
        .face {
            width: 150px;
            height: 150px;
            background: #f1f5f9;
            /* bg-slate-100 */
            border-radius: 50%;
            border: 4px solid #cbd5e1;
            /* border-slate-300 */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .eyes-container {
            display: flex;
            gap: 20px;
        }

        .eye {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 3px solid #cbd5e1;
            /* border-slate-300 */
        }

        .pupil {
            width: 20px;
            height: 20px;
            background: #334155;
            /* bg-slate-700 */
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease-out;
            /* Pour un mouvement fluide */
        }
    </style>

    <!-- Personnage Interactif -->
    <div class="face">
        <div class="eyes-container">
            <div class="eye">
                <div class="pupil"></div>
            </div>
            <div class="eye">
                <div class="pupil"></div>
            </div>
        </div>
    </div>

    <!-- Message d'Avertissement -->
    <div class="mb-4 p-4 text-sm text-yellow-800 bg-yellow-100 border-l-4 border-yellow-400" role="alert">
        <p class="font-bold">Accès Restreint</p>
        <p>Cette application est exclusivement réservée au personnel de la DSI. Toute tentative de connexion non
            autorisée sera enregistrée et signalée.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" value="Nom d'utilisateur" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pupils = document.querySelectorAll('.pupil');

            function moveEyes(event) {
                pupils.forEach(pupil => {
                    // 1. Obtenir les dimensions et la position de l'œil parent
                    const eye = pupil.parentElement;
                    const rect = eye.getBoundingClientRect();
                    const eyeCenterX = rect.left + rect.width / 2;
                    const eyeCenterY = rect.top + rect.height / 2;

                    // 2. Calculer l'angle entre le centre de l'œil et la souris
                    const deltaX = event.clientX - eyeCenterX;
                    const deltaY = event.clientY - eyeCenterY;
                    const angle = Math.atan2(deltaY, deltaX);

                    // 3. Définir la distance maximale de déplacement de la pupille (pour qu'elle reste dans l'œil)
                    const maxMove = rect.width / 4;

                    // 4. Calculer la nouvelle position de la pupille
                    const moveX = Math.cos(angle) * maxMove;
                    const moveY = Math.sin(angle) * maxMove;

                    // 5. Appliquer la transformation
                    // On part de -50%, -50% (pour centrer) et on ajoute le déplacement
                    pupil.style.transform = `translate(calc(-50% + ${moveX}px), calc(-50% + ${moveY}px))`;
                });
            }

            // Écouter le mouvement de la souris sur toute la fenêtre
            window.addEventListener('mousemove', moveEyes);
        });
    </script>
</x-guest-layout>
