import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// window.Echo = new Echo({
//   broadcaster: "pusher",
//   key: import.meta.env.PUSHER_APP_KEY,
//   cluster: import.meta.env.PUSHER_APP_CLUSTER,
//   forceTLS: true,
//   forceTLS: true,
//   encrypted: true,
//   wsHost: window.location.hostname,
//   wsPort: 6001,
//   wssPort: 6001,
//   disableStats: true,
// });

// window.Echo.channel('show.1').listen('SeatBookedEvent', (data) => {
//     console.log('New seat booked:', data);
// });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "./echo";
