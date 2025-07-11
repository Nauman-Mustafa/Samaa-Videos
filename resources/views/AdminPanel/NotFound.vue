<template>
    <div class="container-fluid">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-500 mb-0">
                It looks like you found a glitch in the matrix...
            </p>
            <router-link to="/">&larr; Back to Dashboard</router-link>
        </div>
    </div>
</template>

<style scoped>
.error {
    color: #5a5c69;
    font-size: 7rem;
    position: relative;
    line-height: 1;
    width: 12.5rem;
}

.error:before {
    content: attr(data-text);
    position: absolute;
    left: -2px;
    text-shadow: 1px 0 #4e73df;
    top: 0;
    color: #5a5c69;
    background: #f8f9fc;
    overflow: hidden;
    clip: rect(0, 900px, 0, 0);
    animation: noise-anim-2 3s infinite linear alternate-reverse;
}

.error:after {
    content: attr(data-text);
    position: absolute;
    left: 2px;
    text-shadow: -1px 0 #e74a3b;
    top: 0;
    color: #5a5c69;
    background: #f8f9fc;
    overflow: hidden;
    clip: rect(0, 900px, 0, 0);
    animation: noise-anim 2s infinite linear alternate-reverse;
}

@keyframes noise-anim {
    0% {
        clip: rect(49px, 9999px, 40px, 0);
    }
    100% {
        clip: rect(43px, 9999px, 85px, 0);
    }
}

@keyframes noise-anim-2 {
    0% {
        clip: rect(28px, 9999px, 31px, 0);
    }
    100% {
        clip: rect(13px, 9999px, 86px, 0);
    }
}
</style>
