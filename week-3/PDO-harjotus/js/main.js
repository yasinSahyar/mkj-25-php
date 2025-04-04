'use strict';

const modifyButtons = document.querySelectorAll('.modify-button');
const updateModal = document.querySelector('#update-modal');


modifyButtons.forEach((button) => {
    button.addEventListener('click', async () => {
        const mediaId = button.dataset.media_id;
        console.log(mediaId);
        const response = await fetch('./inc/update-form.php?media_id=' + mediaId);
        const html = await response.text();
        updateModal.innerHTML = '';
        updateModal.insertAdjacentHTML('afterbegin', html);
        updateModal.showModal();
    })
})