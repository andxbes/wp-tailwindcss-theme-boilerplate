/***
 * Любой список не только ul
 * имеющий кнопки .open-btn будет искать при клике родителя содержащего скрытые списки,
 * и ставить или убирать класс .opened
 * ***/

function accordions(el) {
    return {
        dom_el: el,
        open_arrows: null,
        init() {
            let that = this;
            this.open_arrows = this.dom_el.querySelectorAll('.open-btn');
            if (this.open_arrows.length > 0) {
                this.open_arrows.forEach(function (item, idx) {
                    item.addEventListener('click', function (e) {
                        e.stopPropagation();
                        that.toggle(item);
                    });

                });
            }
        },
        toggle($el){
            let has_content_container = $el.classList.contains('has_content') ? $el : $el.closest('.has_content');
            if (has_content_container) {
                has_content_container.classList.toggle('opened');
            }
        }
    }
}

export default accordions;