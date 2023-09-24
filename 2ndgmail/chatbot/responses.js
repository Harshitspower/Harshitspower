function getBotResponse(input) {
    if (input.toLowerCase() == "hello" || input.toLowerCase() == "hey") {
        return "Hello there!";
    } else if (input.toLowerCase() == "tell me about yourself") {
        return "I am a chatbot here to help you with your basic queries.";
    } else if (input.toLowerCase() == "goodbye") {
        return "Talk to you later!";
    } else {
        return "You can visit <a href='https://complyrelax.com/' target='_blank'>https://complyrelax.com/</a> for more information.";
    }
}
