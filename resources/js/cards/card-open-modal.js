import {addTransition} from "../lists/card-list-modal.js";

window.addEventListener('open-card-modal', ({ detail: { cardId } }) => {
    let modalContainer = document.getElementById('card-modal-container');
    let currentModal = null;

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
