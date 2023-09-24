document.addEventListener("DOMContentLoaded", function() {
	const chatbotMessage = document.getElementById("chatbotMessage");
	const closeButton = document.getElementById("closeButton");
  
	// Display the chatbot message inside the chatbox
	chatbotMessage.style.display = "block";
	
	closeButton.addEventListener("click", function() {
	  chatbotMessage.style.animation = "slideOut 1s forwards";
	  setTimeout(function() {
		chatbotMessage.style.display = "none"; 
	  }, 1000);
	});
  
	setTimeout(function() {
	  chatbotMessage.style.animation = "slideOut 1s forwards";
	  setTimeout(function() {
		chatbotMessage.style.display = "none"; 
	  }, 1000);
	}, 3000);
  });


const textarea = document.querySelector('.chatbox-message-input')
const chatboxForm = document.querySelector('.chatbox-message-form')


window.addEventListener('load', function () {
    setTimeout(function() {
        autoReply('hi'|| 'hello' || 'hey');
    }, 1000);
});

textarea.addEventListener('input', function () {
	let line = textarea.value.split('\n').length

	if(textarea.rows < 6 || line < 6) {
		textarea.rows = line
	}

	if(textarea.rows > 1) {
		chatboxForm.style.alignItems = 'flex-end'
	} else {
		chatboxForm.style.alignItems = 'center'
	}
})

const chatboxToggle = document.querySelector('.chatbox-toggle')
const chatboxMessage = document.querySelector('.chatbox-message-wrapper')
const closeBtn = document.querySelector('.close-button');

chatboxToggle.addEventListener('click', function () {
	chatboxMessage.classList.toggle('show')
})

closeBtn.addEventListener('click', function() {
      chatboxMessage.classList.remove('show');
});


const dropdownToggle = document.querySelector('.chatbox-message-dropdown-toggle')
const dropdownMenu = document.querySelector('.chatbox-message-dropdown-menu')

dropdownToggle.addEventListener('click', function () {
	dropdownMenu.classList.toggle('show')
})

document.addEventListener('click', function (e) {
	if(!e.target.matches('.chatbox-message-dropdown, .chatbox-message-dropdown *')) {
		dropdownMenu.classList.remove('show')
	}
  })

// CHATBOX MESSAGE
const chatboxMessageWrapper = document.querySelector('.chatbox-message-content')
const chatboxNoMessage = document.querySelector('.chatbox-message-no-message')

chatboxForm.addEventListener('submit', function (e) {
	e.preventDefault()
    var usertext = textarea.value.trim().replace(/\n/g, '<br>\n');
	if(isValid(textarea.value)) {
		writeMessage(usertext)
		setTimeout(autoReply(usertext.toLowerCase()), 1000)
	}
})


function addZero(num) {
	return num < 10 ? '0'+num : num
}

function writeMessage(usertext) {
	const today = new Date()
	let message = `
		<div class="chatbox-message-item sent">
			<span class="chatbox-message-item-text">
				${usertext.trim().replace(/\n/g, '<br>\n')}
			</span>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>
	`
	chatboxMessageWrapper.insertAdjacentHTML('beforeend', message)
	chatboxForm.style.alignItems = 'center'
	textarea.rows = 1
	textarea.focus()
	textarea.value = ''
	chatboxNoMessage.style.display = 'none'
	scrollBottom()
}

function autoReply(userMessage) {
	const today = new Date();
	
   
	let response = '';
	let message1 = '';
    
	if (userMessage.startsWith('hi') || userMessage.startsWith('hello') || userMessage.startsWith('hey')) {
		response = 'Hello! My name is Cherish. How can I help you?';
		message1 = `<div class="chatbox-message-item received">
		<span class="chatbox-message-item-text">
    What information are you looking for? 
		</span>		
		<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
		<a onclick="aclick('About Us')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">About Us</a>
		<a onclick="aclick('Account')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Account</a>
		<a onclick="aclick('Demo')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Demo</a>
		<a onclick="aclick('Instruction')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Instruction</a>
		<a onclick="aclick('Subscription')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Subscription</a>
		<a onclick="aclick('Contact Us')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Contact Us</a>
		<a onclick="aclick('Other Queries')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Other Queries</a>
		<a onclick="aclick('Privacy Policy')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Privacy Policy</a>
		<a onclick="aclick('Terms & Conditions')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Terms & Conditions </a>
		<a onclick="aclick('EULA')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">EULA</a></div>
		<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	  </div>`;
	} else if (userMessage.includes('help')) {
		response = "Sure, I'm here to help! What do you need assistance with?";
	}else {
		response = 'Please select the option that I give you.';		
	}
  
	let message = `
		<div class="chatbox-message-item received">
			<span class="chatbox-message-item-text">
				${response}
			</span>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>
	`;

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', message);
    
	if (message1 !== '') {
		chatboxMessageWrapper.insertAdjacentHTML('beforeend', message1);
	}	
	scrollBottom();
}

function aclick(option) {
	const today = new Date();
	var usertext = option.trim().replace(/\n/g, '<br>\n');
	if (isValid(option)) {
		writeMessage(usertext);
	}
	const scrollBottom = () => {
		chatboxMessageWrapper.scrollTop = chatboxMessageWrapper.scrollHeight;
	};
	const typingIndicator = document.createElement('div');
	typingIndicator.classList.add('loader');
	chatboxMessageWrapper.insertAdjacentElement('beforeend', typingIndicator);
	if (option === 'About Us') {
		
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
			
			let option3Response = `<div class="chatbox-message-item received">
				<span class="chatbox-message-item-text">
				You can know more about us on the following link:</br>
				<a href="https://complyrelax.com/about-us.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/about-us.php</a>
				</span>
				<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
			</div>`;
			typingIndicator.remove();
			chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
			scrollBottom();
		})();
	}else if (option === 'Account') {
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
		  let accountOptions = `<div class="chatbox-message-item received">
			<span class="chatbox-message-item-text">
			  Please select an option:
			</span>
			<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
			  <a onclick="aclick('How do I create an account')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">How do I create an account</a>
			  <a onclick="aclick('How do I login to my account')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">How do I login to my account</a>
			  <a onclick="aclick('Can you provide more information about a specific product/service?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Can you provide more information </br>about a specific product/service?</a>
			</div>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		  </div>`;
		  typingIndicator.remove();	
		  chatboxMessageWrapper.insertAdjacentHTML('beforeend', accountOptions);
		  scrollBottom();
		})();
	  }else if (option === 'How do I create an account') {
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
		let option3Response = `<div class="chatbox-message-item received">
		  <span class="chatbox-message-item-text">
		  Please click on the following link and enter your details for creating your account with us:</br>
      <a href="https://complyrelax.com/Task-Management/signup" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Task-Management/signup</a>
		  </span>
		  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>`;
		typingIndicator.remove();
	
		chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
		scrollBottom();
	})();
	  }else if (option === 'How do I login to my account') {
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
		let option3Response = `<div class="chatbox-message-item received">
		  <span class="chatbox-message-item-text">
		  Please click on the following link, enter your credentials and click on the login button:</br>
      <a href="https://complyrelax.com/Task-Management/signin" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Task-Management/signin</a>
		  </span>
		  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>`;
		typingIndicator.remove();
	
		chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
		scrollBottom();
	})();
	  }else if (option === 'Can you provide more information about a specific product/service?') {
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
		let option3Response = `<div class="chatbox-message-item received">
		  <span class="chatbox-message-item-text">
		  Yes. You can check out the list of features of our software on the following link:</br>
		  <a href="https://complyrelax.com/Features.pdf" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/Features.pdf</a></br>
		  For more information, you can contact our team at <a href="mailto:complyrelax@gmail.com">complyrelax@gmail.com</a> +91 99298 22200 / 99287 22200.
		  </span>
		  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>`;
		typingIndicator.remove();
	
		chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
		scrollBottom();
	})();
	  } else if(option === 'Demo'){
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
		let Demo = `<div class="chatbox-message-item received">
			<span class="chatbox-message-item-text">
				Please select an option:
			</span>
			<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
			<a onclick="aclick('Do you provide demo session?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Do you provide demo session?</a>
			<a onclick="aclick('Is demo recorderd available?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Is demo recorderd available?</a>
			<a onclick="aclick('Book your demo')" href="https://complyrelax.com/schedule-a-demo.php" target="_blank" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Book your demo</a>
			</div>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>`;
		typingIndicator.remove();
    
		chatboxMessageWrapper.insertAdjacentHTML('beforeend', Demo);
		scrollBottom();
	})();
    } else if (option === 'Do you provide demo session?') {
		(async () => {
			await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  Yes we provide free demo session Monday to Friday at 04:00 PM.
	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  } else if (option === 'Is demo recorderd available?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  Yes, if you want we can mail you the link to our recorded demo, please write your email here.
	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if(option === 'Instruction'){
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Instruction = `<div class="chatbox-message-item received">
		<span class="chatbox-message-item-text">
			Please select an option:
		</span>
		<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
		<a onclick="aclick('Can you provide instructions for using a particular feature of your product?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Can you provide instructions for <br/>using a particular feature of your <br/>product?</a>
		<a onclick="aclick('Can you help me troubleshoot an issue I am experiencing with your product/service?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Can you help me troubleshoot <br/> an issue I'm experiencing <br/> with your product/service?</a>
		<a onclick="aclick('Are there any user guides or manuals available for your products?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Are there any user guides <br/> or manuals available for your products?</a>
		</div>
		<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Instruction);
	scrollBottom();
})();
} else if (option === 'Can you provide instructions for using a particular feature of your product?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    You can check out our short help videos on the below mentioned link:</br>
    <a href="https://complyrelax.com/help_videos.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/help_videos.php</a></br>
	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();
	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if (option === 'Can you help me troubleshoot an issue I am experiencing with your product/service?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	   Yes, you can chat with our experts for troubleshooting your issue. <a href="https://api.whatsapp.com/send/?phone=919929822200&text=Chat+With+Us&type=phone_number&app_absent=0 "target="_blank" onclick="openWhatsApp()"><b>Chat with Us.</b></a>
	  	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if (option === 'Are there any user guides or manuals available for your products?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  You can check out our user manual on the below mentioned link:</br>
    <a href="https://complyrelax.com/user_manual.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/user_manual.php</a></br>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if(option === 'Subscription'){
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Subscription = `<div class="chatbox-message-item received">
		<span class="chatbox-message-item-text">
			Please select an option:
		</span>
		<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
		<a onclick="aclick('What plans do you offer?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">What plan do you offer?</a>
		<a onclick="aclick('Do you offer customized plans as well?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">Do you offer customized plans as well?</a>
		<a onclick="aclick('What payment methods do you accept?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">What payment methods do you accept?</a>
		<a onclick="aclick('What is your refund policy?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">What is your refund policy?</a>
	</div>
		<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Subscription);
	scrollBottom();
})();
} else if (option === 'What plans do you offer?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Subscription = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  We have 4 standard plans. You can check out the same on the following link:</br>
    <a href="https://complyrelax.com/pricing.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/pricing.php</a></br>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Subscription);
	scrollBottom();
})();
  }else if (option === 'Do you offer customized plans as well?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    Yes, you can share your requirements with our team and get a customized plan.</br>
    Please note that customized plan starts minimum from client credit-25 and 5-users limit.
	  	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if (option === 'What payment methods do you accept?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    We accept Online Bank Transfer / UPI. We also have online payment gateway available, on which you can initiate payment via debit/credit card/UPI/net banking etc.
	  	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if (option === 'What is your refund policy?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let option3Response = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    If customer is unsatisfied within 10 days of subscription of services, customer can apply to refund by writing to helpdesk with reason for cancellation. Helpdesk will analyse the case and process the refund applicable to designated account. Post 10 days there will be no refund made.
	  	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', option3Response);
	scrollBottom();
})();
  }else if(option === 'Contact Us'){
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Contact = `<div class="chatbox-message-item received">
		<span class="chatbox-message-item-text">
			Please select an option:
		</span>
		<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
		<a onclick="aclick('How do I contact your customer support team?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">How do I contact your customer <br/>support team?</a>
	</div>
		<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Contact);
	scrollBottom();
})();
} else if (option === 'How do I contact your customer support team?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let customer = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  You may write to our team at <a href="mailto:complyrelax@gmail.com">complyrelax@gmail.com</a> or call at +91 99298 22200 / 99287 22200.</br>
	  Chat on Whatsapp – <a href="https://api.whatsapp.com/send/?phone=919929822200&text=Chat+With+Us&type=phone_number&app_absent=0 "target="_blank" onclick="openWhatsApp()">Open whatsapp</a>
	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', customer);
	scrollBottom();
})();
  } else if(option === 'Other Queries'){
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Queries = `<div class="chatbox-message-item received">
		<span class="chatbox-message-item-text">
			Please select an option:
		</span>
		<div id="quickReplyCarouselContainerElement" class="botcart-buttons" style="transform: translateX(0%);">
		<a onclick="aclick('What are your business hours and days of operation?')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">What are your business hours and <br/>days of operation?</a>
		<a onclick="aclick('More Frequently Asked Questions')" href="#" class="button-option" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">More Frequently Asked Questions</a>
		</div>
		<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Queries);
	scrollBottom();
})();
} else if (option === 'What are your business hours and days of operation?') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
	let Queries = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  Monday to Friday – 10:00 AM to 06:00 PM
	  	  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Queries);
	scrollBottom();
})();
  }else if (option === 'More Frequently Asked Questions') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
    let Queries = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
	  You can check out our user manual on the below mentioned link:</br>
    <a href="https://complyrelax.com/faq.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/faq.php</a></br>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Queries);
	scrollBottom();
})();
  }else if (option === 'Privacy Policy') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
    let Privacy = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    Visit the following link for checking out our privacy policy:</br>
    <a href="https://complyrelax.com/privacy-policy.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/privacy-policy.php</a>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Privacy);
	scrollBottom();
})();
  }else if (option === 'Terms & Conditions') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
    let Privacy = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    You can visit the following link for checking out our terms and conditions:</br>
    <a href="https://complyrelax.com/terms-&-condition.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/terms-&-condition.php</a>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
	typingIndicator.remove();

	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Privacy);
	scrollBottom();
})();
  }else if (option === 'EULA') {
	(async () => {
		await new Promise(resolve => setTimeout(resolve, 2000));
    let Privacy = `<div class="chatbox-message-item received">
	  <span class="chatbox-message-item-text">
    Please go to the following link to review our End User Licence Agreement:</br>
    <a href="https://complyrelax.com/EULA.php" target="_blank" style="color: rgb(51, 102, 255); border-color: rgb(51, 102, 255); background-color: white;">https://complyrelax.com/EULA.php</a></br>
  </span>
	  <span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
	</div>`;
    typingIndicator.remove();
	chatboxMessageWrapper.insertAdjacentHTML('beforeend', Privacy);
	scrollBottom();
	
})();
  }
 }
 
function scrollBottom() {
	chatboxMessageWrapper.scrollTo(0, chatboxMessageWrapper.scrollHeight)
}

function isValid(value) {
	let text = value.replace(/\n/g, '')
	text = text.replace(/\s/g, '')

	return text.length > 0
}


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


  const typingIndicator = document.createElement('div');
  typingIndicator.classList.add('loader');
  document.querySelector('.chatbox-message-content').appendChild(typingIndicator);

  // Simulate delay before showing the actual answer
  setTimeout(() => {
    const answer = findAnswer(question);
    if (answer) {
      // Remove typing indicator
      typingIndicator.remove();

      // Display the answer
      writeMessageoption(answer, false, `a${messageId}`);
    }
  }, 2000); // Adjust the delay time (in milliseconds) to control the typing speed
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
    
    return questionToAnswer[question] || "I'm sorry, but I don't have the answer to that question.";
  }

  function scrollBottom() {
    const chatbox = document.querySelector('.chatbox-message-content');
    chatbox.scrollTop = chatbox.scrollHeight;
  }

  
  function search() {
	// Function to search for matching questions based on words from the answers
	const searchedWord = document.getElementById('searchBox').value.toLowerCase().trim();
  
	// Clear previous question suggestions only
	const previousQuestions = document.querySelectorAll('.chatbox-question');
	previousQuestions.forEach((question) => question.remove());
  
	if (searchedWord !== '') {
	  for (const [index, question] of questions.entries()) {
		const answer = findAnswer(question).toLowerCase();
		if (answer.includes(searchedWord)) {
		  writeMessageoption(question, true, `q${index}`);
		}
	  }
	}
  }
  
  function handleUserAnswer(userInput) {
	// Function to handle user's input and display the corresponding question or answer
	const matchingQuestion = questions.find((question) =>
	  userInput.toLowerCase().includes(question.toLowerCase())
	);
  
	if (matchingQuestion) {
	  // If there's a match, display the corresponding question
	  writeMessageoption(matchingQuestion, true, `q${questions.indexOf(matchingQuestion)}`);
	} else {
	  // If there's no match, treat the user's input as an answer
	  writeUserMessage(userInput);
	  showAnswer(userInput); // Show the answer for the user's input
	}
  }
  
  // Event listeners
  document.getElementById('searchBox').addEventListener('input', () => {
	search();
  });
  
  document.querySelector('.chatbox-message-form').addEventListener('submit', (e) => {
	e.preventDefault();
	const userInput = document.getElementById('searchBox').value.trim();
	if (userInput !== '') {
	  handleUserAnswer(userInput);
	  document.getElementById('searchBox').value = '';
	}
  });
  
  // Initial call to display the questions
//   for (const [index, question] of questions.entries()) {
//     writeMessageoption(question, true, `q${index}`);
//   }








