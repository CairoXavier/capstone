const http = require('http');
const { exec } = require('child_process');

const server = http.createServer((req, res) => {
    // Execute the PHP file using child_process.exec()
    exec('php scan.php', (error, stdout, stderr) => {
        if (error) {
            console.error(`Error executing PHP file: ${error}`);
            return;
        }
        // Set Content-Type to text/html if the PHP script returns HTML content
        res.writeHead(200, {'Content-Type': 'text/html'});
        // Send the output of the PHP script as the response
        res.end(stdout);
    });
});

const PORT = 8080;
server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
