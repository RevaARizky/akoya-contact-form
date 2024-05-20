(($) => {
    document.addEventListener("DOMContentLoaded", () => {
        const main = document.querySelector('.select2-custom-package')
        if(!main) return false
        
        function formatState (state) {
            if (!state.id) {
              return state.text;
            }
            var $state = $(
              `<div class="d-flex justify-content-between"><span class="me-1">${state.text}</span><span class="ms-1">${state.element.dataset.subtitle}</span></div>`
            );
            return $state;
          };          

        $(main).select2({
            templateResult: formatState,
            width: '100%',
            allowClear: true,
            multiple: true,
            placeholder: 'Please select treatment',
        });
    })
})(jQuery)