// web3-connection.js
(function ($) {
    async function connectWeb3Wallet() {
        if (typeof window.ethereum === 'undefined') {
            alert('Please install MetaMask or another web3-compatible wallet to connect.');
            return;
        }

        try {
            const provider = new ethers.providers.Web3Provider(window.ethereum);
            const signer = provider.getSigner();
            const address = await signer.getAddress();
            
            // Save the wallet address to the user's metadata
            saveWeb3WalletAddress(address);
        } catch (error) {
            console.error('Failed to connect web3 wallet:', error);
            alert('Failed to connect web3 wallet. Please try again.');
        }
    }

    async function saveWeb3WalletAddress(address) {
        const data = {
            action: 'aihiu_addweb3_save_wallet_address',
            user_id: aihiu_addweb3_wordpress_data.user_id,
            wallet_address: address,
            nonce: aihiu_addweb3_wordpress_data.nonce,
        };

        const response = await $.post(aihiu_addweb3_wordpress_data.ajax_url, data);

        if (response.success) {
            $('#web3_wallet_address').val(address);
            alert('Web3 wallet address saved successfully.');
        } else {
            alert('Failed to save web3 wallet address. Please try again.');
        }
    }

    $(document).ready(function () {
        $('#connect_web3_wallet').on('click', connectWeb3Wallet);
    });
})(jQuery);
