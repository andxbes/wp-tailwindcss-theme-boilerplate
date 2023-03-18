function theme(el) {
    return {
        element: el,
        loading: true,
        options: {
            show_mobile_menu: false,
        },
        modals: {},
        sidebars: {},
        init() {
            this.loading = false;
            console.info('theme.init');
        },
    }
}
export default theme;