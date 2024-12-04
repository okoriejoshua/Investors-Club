window.addEventListener('show-form', event => {
    $('#addForm').modal('show');
});

window.addEventListener('show-suspendModal', event => {
    $('#suspendModal').modal('show');
});

window.addEventListener('show-deleteModal', event => {
    $('#deleteModal').modal('show');
});

window.addEventListener('show-profileModal', event => {
    $('#profileModal').modal('show');
});

window.addEventListener('show-deposit-modal', event => {
    $('#popalert').modal('show');
});


window.addEventListener('show-addFundModal', event => {
    $('#addFundModal').modal('show');
});

window.addEventListener('show-tabModal', event => {
    $('#previewModal').modal('show');
});

window.addEventListener('show-buyModal', event => {
    $('#buyModal').modal('show');
});

window.addEventListener('show-wpin_modal', event => {
    $('#wpmodal').modal('show');
});


window.addEventListener('show-kyc_modal', event => {
    $('#kycmodal').modal('show');
});

window.addEventListener('show-modal-success', event => {
    $('#wdrs').modal('show');
});

window.addEventListener('show-deposit-exist-modal', event => {
    $('#depositexist').modal('show');
});

window.addEventListener('hide-exist-modal', event => {
    $('#depositexist').modal('hide');
});

window.addEventListener('show-change-photo-form', event => {
    $('#uploadtab').css('display', 'block');
});

window.addEventListener('load', function() {
    document.getElementById('pre-loader').style.display = 'none';
});

window.addEventListener('close-modal', event => {
    $('#' + event.detail.modalid).modal('hide');
});


window.addEventListener('open-modal', event => {
    $('#' + event.detail.modalid).modal('show');
});


function copy(selector) {
    TopScroll = window.pageYOffset || document.documentElement.scrollTop;
    LeftScroll = window.pageXOffset || document.documentElement.scrollLeft;

    var $temp = $("<div>");
    $("body").append($temp);
    $temp.attr("contenteditable", true)
        .html($(selector).html()).select()
        .on("focus", function() { document.execCommand('selectAll', false, null); })
        .focus();
    document.execCommand("copy");
    $temp.remove();
    toastr.success('Copied', 'Success!');
    window.scrollTo(LeftScroll, TopScroll);
}



$(function() {
    toastr.options = { "progressBar": true, "timeOut": "4000", }
    window.addEventListener('hide-form', event => {
        $('#addForm').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    });

    window.addEventListener('hide-suspendModal', event => {
        $('#suspendModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');

    });

    window.addEventListener('upload-saved', event => {
        toastr.success(event.detail.message, 'Success!');
    });


    window.addEventListener('kyc-upload-status', event => {
        toastr.success(event.detail.message, 'Success!');

    });

    window.addEventListener('hide-deleteModal', event => {
        $('#deleteModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');

    });
    window.addEventListener('hide-addfundModal', event => {
        $('#addFundModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    });

    if ($('.prevent-default').length) {
        $('.prevent-default').click(function(event) {
            event.stopPropagation();
        });
    }

    window.livewire.on('goBack', () => {
        window.history.back();
    });

    if ($('.goback').length) {
        document.querySelector(".goback").addEventListener("click", () => { window.history.back(); });
    }

    window.addEventListener('form-response-profile-update', event => {
        toastr.success(event.detail.message, 'Success!');
        document.querySelector('.profile-name').innerHTML = event.detail.profile_name;
        document.querySelector('.profile-name-sidebar').innerHTML = event.detail.profile_name;
    });

    window.addEventListener('form-response-photo-update', event => {
        toastr.success(event.detail.message, 'Success!');
        $('#uploadtab').css('display', 'none');
        //update new photo
        document.querySelector('.profile-photo').src = event.detail.photo_url;
        document.querySelector('.profile-photo-sidebar').src = event.detail.photo_url;
    });

    window.addEventListener('form-response-password', event => {
        if (event.detail.status == true) {
            toastr.success(event.detail.message, 'Success!');
        } else {
            toastr.warning(event.detail.message, 'Failed!');
        }
    });

    window.addEventListener('hide-purchaseForm', event => {
        if (event.detail.check == true) {
            $('#buyModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        } else {
            toastr.warning(event.detail.message, 'Failed!');
        }
    });

    window.addEventListener('hide-wpinform', event => {
        if (event.detail.status == true) {
            $('#wpmodal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        } else {
            toastr.warning(event.detail.message, 'Failed!');
        }
    });


    //
});



$(document).ready(function() {
    const modeCheckbox = $('#mode');
    const currentModeSpan = $('#current-mode');

    const isDarkMode = localStorage.getItem('isDarkMode') === 'true';
    if (isDarkMode) {
        $('body').toggleClass('dark-mode');
        $('nav').toggleClass('navbar-dark navbar-light');
        $('aside').toggleClass('sidebar-light-primary sidebar-dark-primary');
        $('aside nav').toggleClass('navbar-dark navbar-light');
        modeCheckbox.prop('checked', true);
        currentModeSpan.text('Day');
    } else {
        currentModeSpan.text('Night');
    }
    modeCheckbox.on('change', function() {
        $('body').toggleClass('dark-mode');
        $('nav').toggleClass('navbar-dark navbar-light');
        $('aside').toggleClass('sidebar-light-primary sidebar-dark-primary');
        $('aside nav').toggleClass('navbar-dark navbar-light');

        localStorage.setItem('isDarkMode', $(this).is(':checked'));
        currentModeSpan.text($(this).is(':checked') ? 'Day' : 'Night');
    });
});









function time_remain(dbDatetime) {
    const endDateTime = new Date(dbDatetime);
    const milliseconds = endDateTime.getTime() - Date.now();
    const countDownTimer = endDateTime.getTime();
    let interval;
    return {
        countDown: milliseconds,
        countDownTimer,
        intervalID: null,
        init() {
            if (!this.intervalID) {
                this.intervalID = setInterval(() => {
                    this.countDown = this.countDownTimer - new Date().getTime();
                }, 1000);
            }
        },
        getTime() {
            if (this.countDown < 0) {
                this.clearTimer();
            }
            return this.countDown;
        },
        formatTime(num) {
            const seconds = Math.floor(num / 1000) % 60;
            const minutes = Math.floor(num / (1000 * 60)) % 60;
            const hours = Math.floor(num / (1000 * 60 * 60)) % 24;
            const days = Math.floor(num / (1000 * 60 * 60 * 24));

            return `${days}d ${hours}h ${minutes}m ${seconds}s`;
        },
        clearTimer() {
            clearInterval(this.intervalID);
        }
    };
}

/*const images = document.querySelectorAll('.image-gallery img');
images.forEach(image => {
    image.addEventListener('click', () => {
        const modal = document.createElement('div');
        modal.classList.add('light-modal');
        

        const modalImage = document.createElement('img');
        modalImage.src = image.src;
        modalImage.classList.add('modal-image');
        modalImage.classList.add('radius-4');


        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('button-container');

        //const link = document.createElement('a');
        //link.classList.add('btn');
        //link.classList.add('btn-default');
        //link.textContent = 'View Details'; 
        
        //link.href = image.id; 
        //buttonContainer.appendChild(link);

        const closeButton = document.createElement('span');
        closeButton.classList.add('close-button');
        closeButton.textContent = '×';

        modal.appendChild(modalImage);
        //modal.appendChild(buttonContainer);
        modal.appendChild(closeButton);
        document.body.appendChild(modal);

        // Close the modal when clicking outside the image, close button, or button itself
        modal.addEventListener('click', (event) => {
            if (event.target === modal || event.target === closeButton) {
                modal.remove();
            }
        });
    });
});
*/