function addTransition(modal, show = true, callback) {
    if (show) {
        modal.style.opacity = 0;
        modal.style.transform = 'scale(0.96)';
        modal.style.transition = 'opacity 0.25s cubic-bezier(.4,0,.2,1), transform 0.25s cubic-bezier(.4,0,.2,1)';
        setTimeout(() => {
            modal.style.opacity = 1;
            modal.style.transform = 'scale(1)';
            if (typeof callback === 'function') callback();
        }, 10);
    } else {
        modal.style.opacity = 0;
        modal.style.transform = 'scale(0.96)';
        setTimeout(() => {
            if (typeof callback === 'function') callback();
        }, 250);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    let modalContainer = document.getElementById('card-modal-container');
    let currentModal = null;
    document.querySelectorAll('.card-list-item').forEach(function(cardItem) {
        cardItem.addEventListener('click', function(e) {
            let cardId = cardItem.getAttribute('data-card-id');
            if (!cardId) return;
            if (currentModal) currentModal.remove();
            fetch(`/api/cards/${cardId}/modal`)
                .then(res => res.json())
                .then(({ html } ) => {
                    let temp = document.createElement('div');
                    temp.innerHTML = html;
                    let modal = temp.firstElementChild;
                    modalContainer.appendChild(modal);
                    currentModal = modal;
                    addTransition(modal, true);
                    modal.style.display = '';
                    modal.addEventListener('click', function(ev) {
                        if (ev.target === modal) {
                            addTransition(modal, false, () => modal.remove());
                        }
                    });
                    let closeBtn = modal.querySelector('[id^="close-card-modal-button-"]');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            addTransition(modal, false, () => modal.remove());
                        });
                    }
                    document.addEventListener('keydown', function escListener(ev) {
                        if (ev.key === 'Escape') {
                            if (currentModal) addTransition(modal, false, () => modal.remove());
                            document.removeEventListener('keydown', escListener);
                        }
                    });
                });
        });
    });
});
