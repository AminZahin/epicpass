<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 48 48"
        fill="none"
        class="epic-pass-icon"
    >
        <defs>
            <!-- Warna Gradient Premium -->
            <linearGradient id="epicGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#4F46E5" /> <!-- Indigo -->
                <stop offset="50%" stop-color="#DB2777" /> <!-- Pink -->
                <stop offset="100%" stop-color="#F97316" /> <!-- Oren -->
            </linearGradient>
            <!-- Efek Bayang-bayang -->
            <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="4" stdDeviation="3" flood-color="#DB2777" flood-opacity="0.3"/>
            </filter>
        </defs>

        <!-- Bentuk Asas Tiket -->
        <path
            fill="url(#epicGradient)"
            filter="url(#shadow)"
            d="M8 15.5A3.5 3.5 0 0 0 11.5 12h25A3.5 3.5 0 0 0 40 15.5v4.2a4.3 4.3 0 0 0 0 8.6v4.2A3.5 3.5 0 0 0 36.5 36h-25A3.5 3.5 0 0 0 8 32.5v-4.2a4.3 4.3 0 0 0 0-8.6v-4.2Z"
        />

        <!-- Huruf 'E' (Telah dibetulkan dari F) -->
        <path
            fill="white"
            d="M16 15.5h14.5a1.8 1.8 0 0 1 0 3.6H20v2.5h8.7a1.7 1.7 0 1 1 0 3.4H20v3.5h10.5a1.8 1.8 0 0 1 0 3.6H16V15.5Z"
        />

        <!-- Garisan Titik/Barcode Tiket -->
        <path
            fill="white"
            opacity=".9"
            d="M34 17.2h2v3.2h-2v-3.2Zm0 5.3h2v3.2h-2v-3.2Zm0 5.3h2V31h-2v-3.2Z"
        />
    </svg>
</template>

<style scoped>
.epic-pass-icon {
    width: 48px; /* Boleh ubah saiz mengikut kesesuaian */
    height: auto;
    transition: transform 0.3s ease;
}
.epic-pass-icon:hover {
    transform: translateY(-2px);
}
</style>