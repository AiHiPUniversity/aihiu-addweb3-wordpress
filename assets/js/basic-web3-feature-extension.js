// basic-web3-feature-extension.js
(function (window, $) {

    // Function to sign a message using the user's web3 wallet
    async function signMessage(message) {
        // Create an ethers.js provider using the connected wallet
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        // Get a signer object from the provider
        const signer = provider.getSigner();
        // Sign the message using the signer
        const signature = await signer.signMessage(message);
        // Return the signature
        return signature;
    }

    // Function to verify a message signature
    async function verifySignature(message, signature, address) {
        // Recover the address from the message signature
        const recoveredAddress = ethers.utils.verifyMessage(message, signature);
        // Check if the recovered address matches the expected address and return the result
        return recoveredAddress === address;
    }

    // Function to send a transaction from the user's web3 wallet
    async function sendTransaction(to, value) {
        // Create an ethers.js provider using the connected wallet
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        // Get a signer object from the provider
        const signer = provider.getSigner();
        // Prepare the transaction object with the recipient and value
        const transaction = {
            to: to,
            value: ethers.utils.parseEther(value),
        };
        // Send the transaction using the signer
        const txResponse = await signer.sendTransaction(transaction);
        // Return the transaction response
        return txResponse;
    }

    // Function to fetch the balance of a user's web3 wallet
    async function fetchWalletBalance(address) {
        // Create an ethers.js provider using the connected wallet
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        // Get the balance of the user's wallet address
        const balance = await provider.getBalance(address);
        // Format the balance in Ether and return it
        return ethers.utils.formatEther(balance);
    }

    // Function to query smart contract data
    async function querySmartContract(contractAddress, abi, functionName, ...args) {
        // Create an ethers.js provider using the connected wallet
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        // Create a contract instance using the contract address and ABI
        const contract = new ethers.Contract(contractAddress, abi, provider);
        // Call the specified function on the contract with the provided arguments
        const result = await contract[functionName](...args);
        // Return the result of the function call
        return result;
    }

    // Expose functions to the global scope
    window.aihiuWeb3 = {
        signMessage,
        verifySignature,
        sendTransaction,
        fetchWalletBalance,
        querySmartContract
    };

})(window, jQuery);
