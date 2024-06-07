const errorHandler = (args) => {
    let arg = {
        el: args.el || document.querySelector('.wpcf7-response-output'),
        message: args.message || "Something went wrong",
        level: args.level || 1
    }
    const errorLevel = ['#46b450', '#ffb900', '#dc3232']
    $(arg.el).empty()
    $(arg.el).append(`<div style="color: ${errorLevel[arg.level]};">${arg.message}</div>`)
    arg.el.style.display = 'block'
}


export default {errorHandler}