(function () {
    'use strict';
    // Focus input if Searchform is empty
    document.querySelectorAll('.search-form').forEach(function (el) {
        el.addEventListener('submit', function (e) {
            var search = el.querySelector('input');
            if (search.value.length < 1) {
                e.preventDefault();
                search.focus();
            }
        });
    });
})();


const contactFormBlocks = document.querySelectorAll('.contact-form-7-block');
let contactFormID, contactFormBtn, contactFormError, contactFormSuccess, contactFormInstance, contactFormSending, contactFormContainer, contactFormHoneyPot, contactFormEmail;



function formsInit() {
    contactFormBlocks.forEach(function (contactFormBlock) {
        contactFormBtn = contactFormBlock.querySelector('.wpcf7-submit');
        contactFormEmail = contactFormBlock.querySelector('.wpcf7-email');
        contactFormID = contactFormBlock.id;
        contactFormBtn.disabled = true;


        contactFormContainer = contactFormBlock.querySelector('.hidden-only-if-sent');
        contactFormSuccess = contactFormBlock.querySelector('.visible-only-if-sent');
        contactFormError = contactFormBlock.querySelector('.visible-only-if-error');
        contactFormSending = contactFormBlock.querySelector('.visible-only-if-sending');
        contactFormHoneyPot = contactFormBlock.querySelector('.honeypot');
        contactFormInstance = contactFormContainer.querySelector('.wpcf7-form');
        console.log(contactFormInstance)


        checkHoneyPot(contactFormHoneyPot, contactFormBtn);
        emailValidation(contactFormEmail, contactFormBtn, contactFormHoneyPot);


        let contactFormStatusSuccess, contactFormStatusInvalid,contactFormStatusSending;

        onClassChange(contactFormInstance, (observer) => {
            contactFormStatusSending = contactFormInstance.classList.contains('submitting');
            contactFormStatusSuccess = contactFormInstance.classList.contains('sent');
            contactFormStatusInvalid = contactFormInstance.classList.contains('failed');
            
            if(contactFormStatusSending){
                contactFormContainer.classList.add = 'fade-out';
                contactFormContainer.style.display = 'none';
                contactFormSending.style.display = 'block';
                contactFormSending.classList.add = 'animate';
            }

            if (contactFormStatusSuccess) {
                contactFormSending.classList.add = 'fade-out';
                contactFormSending.style.display = 'none';
                contactFormSuccess.style.display = 'block';
                contactFormSuccess.classList.add = 'animate';
                observer.disconnect();
            }

            if (contactFormStatusInvalid) {
                contactFormContainer.classList.add = 'fade-out';
                contactFormContainer.style.display = 'none';
                contactFormError.style.display = 'block';
                contactFormError.classList.add = 'animate';
                observer.disconnect();
            }

        });
    });


    expandTextAreaPattern();


}
function onClassChange(node, callback) {
    let lastClassString = node.classList.toString();

    const mutationObserver = new MutationObserver((mutationList) => {
        for (const item of mutationList) {
            if (item.attributeName === "class") {
                const classString = node.classList.toString();
                if (classString !== lastClassString) {
                    callback(mutationObserver);
                    lastClassString = classString;
                    break;
                }
            }
        }
    });

    mutationObserver.observe(node, { attributes: true });

    return mutationObserver;
}


function emailValidation(contactFormEmail, contactFormBtn, contactFormHoneyPot) {

    if (contactFormEmail) {
        contactFormBtn.disabled = true;
        contactFormEmail.addEventListener('input', function (evt) {
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (testEmail.test(this.value)) checkHoneyPot(contactFormHoneyPot, contactFormBtn);
            else contactFormBtn.disabled = true;
        });
    }
}


function checkHoneyPot(honeyPot, contactFormBtn, $class = null) {
    if (honeyPot && honeyPot.value) {
        contactFormBtn.disabled = true;
    } else {
        contactFormBtn.disabled = false;
    }
}

function expandTextAreaPattern() {

    function calcHeight(value) {
        var numberOfLineBreaks = (value.match(/\n/g) || []).length;
        var heightVar = 30;
        var newHeight = heightVar + numberOfLineBreaks * heightVar + 12 + 2;
        return newHeight;
    }

    var textareaEX = document.querySelector("textarea.form-control");

    if (textareaEX) {
        textareaEX.addEventListener("keyup", function () {
            textareaEX.style.height = calcHeight(textareaEX.value) + "px";
        });
    }

    var cf7Formtextarea = document.querySelector('.wpcf7-textarea');

    if (cf7Formtextarea) {
        cf7Formtextarea.addEventListener('keyup', function () {
            pageCheck();
            this.style.overflow = 'hidden';
            this.style.height = 0;
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }
}

if (contactFormBlocks) {
    formsInit();
}


export { formsInit as forms };
