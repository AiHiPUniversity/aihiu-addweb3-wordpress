// web3-connection.js
(function ($) {

    // Function for connecting to the user's web3 wallet (e.g., MetaMask)
    async function connectWeb3Wallet() {
        // Check if a web3-compatible wallet is installed
        if (typeof window.ethereum === 'undefined') {
            alert('Please install MetaMask or another web3-compatible wallet to connect.');
            return;
        }

        // Try connecting to the wallet and getting the user's wallet address
        try {
            // Create an ethers.js provider using the connected wallet
            const provider = new ethers.providers.Web3Provider(window.ethereum);
            // Get a signer object from the provider
            const signer = provider.getSigner();
            // Get the user's wallet address from the signer
            const address = await signer.getAddress();
            
            // Save the wallet address to the user's metadata
            saveWeb3WalletAddress(address);
        } catch (error) {
            console.error('Failed to connect web3 wallet:', error);
            alert('Failed to connect web3 wallet. Please try again.');
        }

        // Check if the user has an existing account and create one if they don't
        const address = await signer.getAddress();
        const userExists = await checkUserExists(address);
        if (!userExists) {
            await createUserWithWallet(address);
        } else {
            // Save the wallet address to the user's metadata
            saveWeb3WalletAddress(address);
        }
    }


    // Function to check if a user exists based on their wallet address
    async function checkUserExists(walletAddress) {
        // Prepare the data to send in the AJAX request
        const data = {
            action: 'aihiu_addweb3_check_user_exists',
            wallet_address: walletAddress,
            nonce: aihiu_addweb3_wordpress_data.nonce,
        };

        // Send the AJAX request to check if the user exists
        const response = await $.post(aihiu_addweb3_wordpress_data.ajax_url, data);
        // Return the success status of the AJAX response (true if the user exists, false otherwise)
        return response.success;
    }


    // Function to create a new user with a linked wallet address
    async function createUserWithWallet(walletAddress) {
        // Prepare the data to send in the AJAX request
        const data = {
            action: 'aihiu_addweb3_create_user_with_wallet',
            wallet_address: walletAddress,
            nonce: aihiu_addweb3_wordpress_data.nonce,
        };

        // Send the AJAX request to create a new user with the provided wallet address
        const response = await $.post(aihiu_addweb3_wordpress_data.ajax_url, data);
        // If the AJAX request is successful, display a success message
        if (response.success) {
            alert('Account created successfully. You can now sign in with your web3 wallet.');
        } else {
            // If the AJAX request fails, display an error message
            alert('Failed to create an account. Please try again.');
        }
    }


    // Function for saving the user's wallet address to their metadata
    async function saveWeb3WalletAddress(address) {
        // Prepare the data to send in the AJAX request
        const data = {
            action: 'aihiu_addweb3_save_wallet_address',
            user_id: aihiu_addweb3_wordpress_data.user_id,
            wallet_address: address,
            nonce: aihiu_addweb3_wordpress_data.nonce,
        };

        // Send the AJAX request to save the wallet address
        const response = await $.post(aihiu_addweb3_wordpress_data.ajax_url, data);

        // If the AJAX request is successful, update the wallet address input field and display a success message
        if (response.success) {
            $('#web3_wallet_address').val(address);
            alert('Web3 wallet address saved successfully.');
        } else {
            alert('Failed to save web3 wallet address. Please try again.');
        }
    }

    // Set up a click event handler for the "Connect Web3 Wallet" button
    $(document).ready(function () {
        $('#connect_web3_wallet').on('click', connectWeb3Wallet);
    });

})(jQuery);
