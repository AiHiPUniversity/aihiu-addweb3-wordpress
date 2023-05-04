// Import Web3 library
import Web3 from 'web3';

// Initialize the Web3 instance
let web3;

// Check if the browser has a Web3 provider
if (typeof window.ethereum !== 'undefined') {
  web3 = new Web3(window.ethereum);
} else {
  // Log a message to inform the user to install a Web3-compatible browser
  console.log('Please install MetaMask or another Web3-compatible browser.');
}

// Function to log in or register with the Web3 wallet
async function aihiu_addweb3wp_loginRegister() {
  try {
    // Request account access
    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });

    // Get the connected wallet's address
    const walletAddress = accounts[0];

    // Send the wallet address to the server-side PHP file for processing
    const response = await fetch(ajaxurl, {
      method: 'POST',
      body: new URLSearchParams({
        action: 'aihiu_addweb3wp_login_register',
        walletAddress,
      }),
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    });

    // Process the response and display a success message
    const data = await response.json();
    if (data.success) {
      console.log('Logged in/registered successfully.');
      // Redirect the user to the desired page after successful login or registration
      window.location.href = 'path/to/redirect';
    } else {
      console.log('Error logging in/registering.');
    }
  } catch (error) {
    // Log any errors
    console.error('Error logging in/registering:', error);
  }
}

  
  // Add an event listener for the login/register button
  document.getElementById('aihiu_addweb3wp_login_register_button').addEventListener('click', aihiu_addweb3wp_loginRegister);
  