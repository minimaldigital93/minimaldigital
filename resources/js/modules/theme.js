/**
 * Light / Dark / Auto theme with persisted preference.
 * The <html> class is set inline in the layout <head> to avoid a flash;
 * this store keeps the toggle button and OS changes in sync afterwards.
 */
export function initTheme(Alpine) {
    const media = window.matchMedia('(prefers-color-scheme: dark)');

    const resolve = (preference) =>
        preference === 'auto' ? (media.matches ? 'dark' : 'light') : preference;

    Alpine.store('theme', {
        preference: localStorage.getItem('theme') ?? 'auto',

        get resolved() {
            return resolve(this.preference);
        },

        set(preference) {
            this.preference = preference;
            localStorage.setItem('theme', preference);
            this.apply();
        },

        cycle() {
            const order = ['light', 'dark', 'auto'];
            this.set(order[(order.indexOf(this.preference) + 1) % order.length]);
        },

        apply() {
            document.documentElement.classList.toggle('dark', this.resolved === 'dark');
        },
    });

    media.addEventListener('change', () => Alpine.store('theme').apply());
}
