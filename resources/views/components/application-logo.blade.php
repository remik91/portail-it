<svg {{ $attributes }} viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <!--
        Ce SVG est conçu pour remplacer le logo par défaut de Laravel.
        Il accepte les attributs passés au composant, comme les classes de taille (ex: h-9 w-auto).
    -->

    <!-- Arrière-plan en forme d'hexagone avec un dégradé de gris foncé -->
    <defs>
        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#4A5568;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#2D3748;stop-opacity:1" />
        </linearGradient>
    </defs>
    <path fill="url(#logoGradient)" d="M86.6 25 L50 2.68 L13.4 25 L13.4 75 L50 97.32 L86.6 75 Z"></path>

    <!-- Initiales "ITP" (IT Portail) au centre, en bleu vif -->
    <text x="50" y="62" font-family="Figtree, sans-serif" font-size="40" font-weight="bold" fill="#3B82F6"
        text-anchor="middle">
        ITP
    </text>
</svg>
