  const questions = [
    'How do I create an account on your website?',
    'How do I login to my account on your website?',
    'Can you provide more information about a specific product/service?',
    'Do you provide a demo session?',
    'Do you have recorded demo session?',
    'Book your demo ',
    'Can you provide instructions for using a particular feature of your product?',
    'Can you help me troubleshoot an issue I am experiencing with your product/service? ',
    'Are there any user guides or manuals available for your products?',
    'What plan do you offer?',
    'Do you offer customized plans as well?',
    'What payment methods do you accept?',
    'What is your refund policy?',
    'How do I contact your customer support team?',
    'What are your business hours and days of operation?',
    'Visit the following link for checking out our privacy policy',
    'You can visit the following link for checking out our terms and conditions:',
    'Please go to the following link to review our End User Licence Agreement:',
  ];

  function writeUserMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.classList.add('chatbox-user-message');
    document.querySelector('.chatbox-message-content').appendChild(messageDiv);
  }

  function writeMessageoption(message, isQuestion, messageId) {
    const messageDiv = document.createElement('div');
    messageDiv.innerHTML = message;
    messageDiv.classList.add(isQuestion ? 'chatbox-question' : 'chatbox-answer');

    messageDiv.setAttribute('data-message-id', messageId);

    if (isQuestion) {
      messageDiv.addEventListener('click', () => {
      const previousQuestions = document.querySelectorAll('.chatbox-question');
      previousQuestions.forEach((item) => item.remove());

      var usertext = message.trim().replace(/\n/g, '<br>\n');
      if(isValid(message)) {
        writeMessage(usertext);
      }
      showAnswer(usertext);        
      });
    }
    document.querySelector('.chatbox-message-content').appendChild(messageDiv);
    scrollBottom();
  }

  function showAnswer(question) {
    const messageId = question.toLowerCase().replace(/[^a-z0-9]/gi, '');

    // Clear previous answer and question, if any
    const previousAnswer = document.querySelector(`[data-message-id="${messageId}"].chatbox-answer`);
    if (previousAnswer) {
      previousAnswer.remove();
    }
    const previousQuestion = document.querySelector(`[data-message-id="${messageId}"].chatbox-question`);
    if (previousQuestion) {
      previousQuestion.remove();
    }

    const answer = findAnswer(question);
    if (answer) {
      writeMessageoption(answer, false, `a${messageId}`);
    }
  }

  function findAnswer(question) {
    const questionToAnswer = {
      'How do I create an account on your website?': 'Please click on the following link and enter your details for creating your account with us:<br /><a href="https://complyrelax.com/Task-Management/signup" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Task-Management/signup</a>',
      'How do I login to my account on your website?': 'Please click on the following link and enter your details for creating your account with us:<br /><a href="https://complyrelax.com/Task-Management/signup" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Task-Management/signup</a>',
      'Can you provide more information about a specific product/service?':  'Yes. You can check out the list of features of our software on the following link:</br><a href="https://complyrelax.com/Features.pdf" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Features.pdf</a>For more information, you can contact our team at <a href="mailto:complyrelax@gmail.com">complyrelax@gmail.com</a> +91 99298 22200 / 99287 22200.',
      'Do you provide a demo session?': 'Yes we provide free demo session Monday to Friday at 04:00 PM.',
      'Do you have recorded demo session?':'Yes, if you want we can mail you the link to our recorded demo, please write your email here.',
      'Book your demo ' : '<a href="https://complyrelax.com/schedule-a-demo.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/schedule-a-demo.php</a>',
      'Can you provide instructions for using a particular feature of your product?' : 'You can check out our short help videos on the below mentioned link:<br /><a href="https://complyrelax.com/help_videos.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/help_videos.php</a>',
      'Can you help me troubleshoot an issue I am experiencing with your product/service?' : 'Yes, you can chat with our experts for troubleshooting your issue. <a href="https://api.whatsapp.com/send/?phone=919929822200&text=Chat+With+Us&type=phone_number&app_absent=0 "target="_blank" onclick="openWhatsApp()"><b>Chat with Us.</b></a>',
      'Are there any user guides or manuals available for your products?' : 'You can check out our user manual on the below mentioned link:</br><a href="https://complyrelax.com/user_manual.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/user_manual.php</a>',
      'What plan do you offer?' : 'We have 4 standard plans. You can check out the same on the following link:</br><a href="https://complyrelax.com/pricing.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/pricing.php</a></br>',
      'Do you offer customized plans as well?' : 'Yes, you can share your requirements with our team and get a customized plan.</br>Please note that customized plan starts minimum from client credit-25 and 5-users limit.',
      'What payment methods do you accept?' : 'We accept Online Bank Transfer / UPI. We also have online payment gateway available, on which you can initiate payment vie debit/credit card/UPI/net banking etc.',
      'What is your refund policy?' : 'If customer is unsatisfied within 10 days of subscription of services, customer can apply to refund by writing to helpdesk with reason for cancellation. Helpdesk will analyse the case and process the refund applicable to designated account. Post 10 days there will be no refund made.',
      'How do I contact your customer support team?' : 'You may write to our team at <a href="mailto:complyrelax@gmail.com">complyrelax@gmail.com</a> or call at +91 99298 22200 / 99287 22200.</br>Chat on Whatsapp – <a href="https://api.whatsapp.com/send/?phone=919929822200&text=Chat+With+Us&type=phone_number&app_absent=0 "target="_blank" onclick="openWhatsApp()">Open whatsapp</a>',
      'What are your business hours and days of operation?' : 'Monday to Friday – 10:00 AM to 06:00 PM',
      'Visit the following link for checking out our privacy policy' : 'Visit the following link for checking out our privacy policy:<a href="https://complyrelax.com/schedule-a-demo.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/schedule-a-demo.php</a>',
      'You can visit the following link for checking out our terms and conditions:' : 'You can visit the following link for checking out our terms and conditions:<a href="https://complyrelax.com/terms-&-condition.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/terms-&-condition.php</a>',
      'Please go to the following link to review our End User Licence Agreement:' : '<a href="https://complyrelax.com/EULA.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/EULA.php</a>',
    };
  }

  function scrollBottom() {
    const chatbox = document.querySelector('.chatbox-message-content');
    chatbox.scrollTop = chatbox.scrollHeight;
  }

  
  function search() {
    const searchedWord = document.getElementById('searchBox').value.toLowerCase().trim();
  
    // Clear previous question suggestions only
    const previousQuestions = document.querySelectorAll('.chatbox-question');
    previousQuestions.forEach((question) => question.remove());
  
    if (searchedWord !== '') {
      for (const [index, question] of questions.entries()) {
        if (question.toLowerCase().includes(searchedWord)) {
          writeMessageoption(question, true, `q${index}`);
        }
      }
    }
  }
  
  // Function to handle click on a question suggestion
  function handleQuestionClick(question) {
    showAnswer(question);
  }
  
  // Event listeners
  document.getElementById('searchBox').addEventListener('input', () => {
    search();
  });
  
  document.querySelector('.chatbox-message-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const userInput = document.getElementById('searchBox').value.trim();
    if (userInput !== '') {
      writeUserMessage(userInput);
      document.getElementById('searchBox').value = '';
    }
  });
  
  // Initial call to display the questions
  for (const [index, question] of questions.entries()) {
    writeMessageoption(question, true, `q${index}`);
  }







