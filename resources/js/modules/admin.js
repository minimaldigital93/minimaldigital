import Sortable from 'sortablejs';

/**
 * Admin-only behaviours: drag-and-drop reordering and
 * drag-and-drop media uploads. All opt-in via data attributes.
 */
export function initAdmin() {
    initSortableLists();
    initDropzone();
}

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

function initSortableLists() {
    document.querySelectorAll('[data-sortable-url]').forEach((list) => {
        Sortable.create(list, {
            animation: 180,
            handle: '[data-sort-handle]',
            ghostClass: 'opacity-40',
            onEnd: async () => {
                const order = [...list.querySelectorAll('[data-id]')].map((el) => el.dataset.id);

                const response = await fetch(list.dataset.sortableUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order }),
                });

                const indicator = document.querySelector('[data-sort-status]');
                if (indicator) {
                    indicator.textContent = response.ok ? 'Order saved' : 'Failed to save order';
                    indicator.classList.remove('hidden');
                    setTimeout(() => indicator.classList.add('hidden'), 2200);
                }
            },
        });
    });
}

function initDropzone() {
    const zone = document.querySelector('[data-dropzone]');
    if (!zone) return;

    const input = zone.querySelector('input[type=file]');

    ['dragenter', 'dragover'].forEach((event) =>
        zone.addEventListener(event, (e) => {
            e.preventDefault();
            zone.classList.add('ring-2', 'ring-primary-500');
        })
    );

    ['dragleave', 'drop'].forEach((event) =>
        zone.addEventListener(event, (e) => {
            e.preventDefault();
            zone.classList.remove('ring-2', 'ring-primary-500');
        })
    );

    zone.addEventListener('drop', (e) => {
        if (!e.dataTransfer?.files?.length) return;
        input.files = e.dataTransfer.files;
        input.closest('form')?.submit();
    });

    input?.addEventListener('change', () => {
        if (input.files.length) input.closest('form')?.submit();
    });
}
