import { addList } from "./list-ui";
import {updateTerminal} from "./list-edit.js";

async function renderList(listId) {
    try {
        const renderUrl = `/api/lists/${listId}/render`;
        const renderResponse = await fetch(renderUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });
        const renderData = await renderResponse.json();

        if (renderData.success && renderData.html) {
            return renderData.html;
        }
        return null;
    } catch (error) {
        console.error('Error rendering list:', error);
        return null;
    }
}

async function createList(url, formData) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData,
        });
        const data = await response.json();

        if (data.success && data.list) {
            showSuccessToast(data.message || 'List created successfully!');
            if (data.terminal) {
                try {
                    updateTerminal(data.list.id);
                } catch (e) {
                }
            }
            document.querySelector('#board-list-count').innerHTML = data.listsCount;
            return data.list;
        } else {
            showErrorToast(data.message || 'Error creating list');
            return null;
        }
    } catch (error) {
        console.error('Error creating list:', error);
        showErrorToast('Error occurred on list creation');
        return null;
    }
}

async function handleListCreation(modalForm) {
    const formData = new FormData(modalForm);
    const url = modalForm.action;
    const submitBtn = modalForm.querySelector('[type="submit"]');

    if (submitBtn) submitBtn.disabled = true;

    try {
        const list = await createList(url, formData);

        if (list) {
            const listHtml = await renderList(list.id);

            if (listHtml) {
                addList(list, listHtml);
                window.dispatchEvent(new CustomEvent('close-create-list-modal'));
            }
        }
    } finally {
        if (submitBtn) submitBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modalForms = document.querySelectorAll('.list-create-modal-form');
    if (!modalForms) return;

    modalForms.forEach(modalForm => {
        modalForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            await handleListCreation(modalForm);
        });
    });
});

