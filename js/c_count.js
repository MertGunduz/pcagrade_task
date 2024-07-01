document.addEventListener("DOMContentLoaded", function() {
    // TEXTAREA ELEMENTS
    const textarea = document.getElementById("cc-textarea");
    const textareaCounter = document.getElementById("message-character-counter-p");

    const textareaCount = textarea.value.length;
    textareaCounter.textContent = textareaCount + " / 256 Characters";

    textarea.addEventListener("input", function() {
        const textareaCount = textarea.value.length;
        textareaCounter.textContent = textareaCount + " / 256 Characters";
    });
});
