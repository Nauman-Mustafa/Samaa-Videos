// tokenHelper.js
import store from "../store"; // Adjust this path based on your store location

export function getToken() {
    return store.state.token;
}
