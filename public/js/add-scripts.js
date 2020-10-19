document.querySelectorAll('.course-module-item').forEach(item => {
    item.addEventListener('click', event => {
        console.log("Content Type: "+this.dataset.contentType+" Content Id: "+this.dataset.contentId);
    });
});
