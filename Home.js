function toggleAnswer(index) {
    var answer = document.getElementById('answer' + index);
    var faqItem = document.getElementsByClassName('faq-item')[index - 1];

    if (answer.style.display === 'block') {
        answer.style.display = 'none';
        faqItem.classList.remove('active');
    } else {
        answer.style.display = 'block';
        faqItem.classList.add('active');
    }
}
