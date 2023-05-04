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

// Function to connect the Web3 wallet
async function aihiu_addweb3wp_connectWallet() {
  try {
    // Request account access
    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });

    // Get the connected wallet's address
    const walletAddress = accounts[0];

    // Send the wallet address to the server-side PHP file for processing
    // Replace the URL with the actual URL to the PHP file
    const response = await fetch(ajaxurl, {
      method: 'POST',
      body: new URLSearchParams({
        action: 'aihiu_addweb3wp_connect_wallet',
        walletAddress,
      }),
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    });

    // Process the response and display a success message
    const data = await response.json();
    if (data.success) {
      console.log('Wallet connected successfully.');
    } else {
      console.log('Error connecting wallet.');
    }
  } catch (error) {
    // Log any errors
    console.error('Error connecting wallet:', error);
  }
}

// Function to disconnect the Web3 wallet
function aihiu_addweb3wp_disconnectWallet() {
  // Send a request to the server-side PHP file to remove the wallet address from the user meta
  // Replace the URL with the actual URL to the PHP file
  fetch(ajaxurl, {
    method: 'POST',
    body: new URLSearchParams({
      action: 'aihiu_addweb3wp_disconnect_wallet',
    }),
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log('Wallet disconnected successfully.');
      } else {
        console.log('Error disconnecting wallet.');
      }
    })
    .catch((error) => {
      console.error('Error disconnecting wallet:', error);
    });
}

// Add event listeners for the connect and disconnect buttons
document.getElementById('aihiu_addweb3wp_connect_button').addEventListener('click', aihiu_addweb3wp_connectWallet);
document.getElementById('aihiu_addweb3wp_disconnect_button').addEventListener('click', aihiu_addweb3wp_disconnectWallet);
