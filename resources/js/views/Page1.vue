<template>
    <div>
        <div>
            Welcome to page 1 - Data from storage {{ $store.getters.data }}
        </div>
        <div>
            <Carousel />
        </div>
    </div>
</template>

<script>
import Carousel from "../components/carousel";
export default {
    components: {
        Carousel
    }
};
</script>

<style></style>
