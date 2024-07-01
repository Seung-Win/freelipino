const express = require('express');
const app = express();
const port = 3000;

let users = [
    { username: 'admin' },
    { username: 'user1' },
    { username: 'user2' }
];
let pageViews = 0;

app.use((req, res, next) => {
    if (req.path === '/') {
        pageViews++;
    }
    next();
});

app.use(express.static('public'));

app.get('/api/stats', (req, res) => {
    res.json({
        userCount: users.length,
        pageViews: pageViews,
        users: users
    });
});

app.listen(port, () => {
    console.log(`Server is running at http://localhost:${port}`);
});
