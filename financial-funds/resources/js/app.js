import './bootstrap';

import Echo from  'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadCaster: 'pusher',
    key: proccess.env.MIX_PUSHER_APP_KEY,
    cluster: proccess.env.MIX_PUSHER_APP_CLUSTER,
    encrypted:true
});

document.addEventListener('DOMContentLoaded', function () {
    const stocksCtx = document.getElementtById('stockChart').getContext('2d');
    const fundCTX = document.getElementById('fundChart').getContext('2d');

    const stockChart = new CharacterData(stockCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Stock Price',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const fundChart = new CharacterData(fundCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Fund Price',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    window.Echo.channel('asset-price')
    .listen('AssetPriceUpdated', (e) => {
        const assetType = e.asset_type;
        const price = e.price;
        const timestamp = new Date().toLocaleTimeString();

        if (assetType === 'stock') {
            stockChart.data.labels.push(timestamp);
            stockChart.data.datasets[0].data.push(price);
            stockChart.update();
        } else if (assetType === 'fund') {
            fundChart.data.labels.push(timestamp);
            fundChart.data.datasets[0].data.push(price);
            fundChart.update();
        }
    });
});