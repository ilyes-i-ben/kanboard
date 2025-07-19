<script>
    function boardsIndex() {
        return {
            showCreateModal: false,
            activeInvitationModal: null,

            openInvitationModal(invitationId) {
                this.activeInvitationModal = invitationId;
            },
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const addCategoryBtn = document.getElementById('add-category');
        const categoriesList = document.getElementById('categories-list');

        if (addCategoryBtn && categoriesList) {
            addCategoryBtn.addEventListener('click', function() {
                const newCategory = document.createElement('div');
                newCategory.className = 'flex items-center space-x-3';
                newCategory.innerHTML = `
                    <input
                        type="text"
                        name="categories[]"
                        class="flex-1 bg-white/90 dark:bg-white/10 backdrop-blur-sm border border-gray-300 dark:border-white/20 rounded-xl px-4 py-2 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-500/50 dark:focus:ring-white/30 focus:border-blue-400 dark:focus:border-white/40"
                        placeholder="${addCategoryBtn.dataset.placeholder || 'Category name...'}"
                    />
                    <button
                        type="button"
                        class="remove-category p-2 rounded-xl bg-red-500/20 backdrop-blur-sm text-red-600 dark:text-red-300 hover:bg-red-500/30 transition-colors"
                        title="${addCategoryBtn.dataset.removeTitle || 'Remove'}"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;

                categoriesList.appendChild(newCategory);

                const removeBtn = newCategory.querySelector('.remove-category');
                removeBtn.addEventListener('click', function() {
                    newCategory.remove();
                    updateRemoveButtons();
                });

                updateRemoveButtons();
            });

            function updateRemoveButtons() {
                const categories = categoriesList.querySelectorAll('.flex');
                categories.forEach((category, index) => {
                    const removeBtn = category.querySelector('.remove-category');
                    if (categories.length > 1) {
                        removeBtn.classList.remove('opacity-0');
                    } else {
                        removeBtn.classList.add('opacity-0');
                    }
                });
            }

            categoriesList.addEventListener('click', function(e) {
                if (e.target.closest('.remove-category')) {
                    e.target.closest('.flex').remove();
                    updateRemoveButtons();
                }
            });

            updateRemoveButtons();
        }
    });
</script>
