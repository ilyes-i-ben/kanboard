<style>
    /* Custom animations */
    @keyframes pulse {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.4; }
    }

    .animate-pulse {
        animation: pulse 4s ease-in-out infinite;
    }

    .delay-1000 { animation-delay: 1s; }
    .delay-2000 { animation-delay: 2s; }
    .delay-3000 { animation-delay: 3s; }

    /* Line clamp utility */
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>
