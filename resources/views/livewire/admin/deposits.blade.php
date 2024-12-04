<style>
    .modal {
        display: none;
        /* Initially hidden */
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0;
        /* Initially zero height */
        background-color: rgba(0, 0, 0, 0.8);
        transition: height 0.3s ease-in-out;
    }

    .modal.show {
        height: 30%;
        /* Adjust the height as needed */
    }

    .modal-content {
        background-color: #fff;
        color: #000;
        padding: 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
</style>
<button id="openModalBtn">Open Modal</button>

<div id="modal" class="modal">
    <div class="modal-content">
        <p>This is the modal content.</p>
        <button id="closeModalBtn">Close Modal</button>
    </div>
</div>

<script>
    const openModalBtn = document.getElementById('openModalBtn');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('closeModalBtn');

    openModalBtn.addEventListener('click', () => {
        modal.classList.add('show');
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.remove('show');
    });
</script>