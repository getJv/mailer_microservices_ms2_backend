<template>
    <v-app>
        <v-app-bar :elevation="1" app clipped-left>
            <v-app-bar-nav-icon
                color="blue-grey darken-5"
                @click.stop="drawer = !drawer"
            />
            <v-toolbar-title>My Starter App</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-app-bar>

        <v-main>
            <h1>Vue Router Demo App</h1>

            <p>
                <router-link :to="{ name: 'page1' }">Go to Page 1</router-link>
                |
                <router-link :to="{ name: 'page2' }">Go to Page 2</router-link>
            </p>

            <div class="container">
                <router-view></router-view>
            </div>
        </v-main>

        <v-footer app color="blue-grey lighten-5">
            <span>
                <small class="caption">
                    &copy; {{ new Date().getFullYear() }} — My Starter App |
                    Version:
                    {{ numVersion }}
                </small>
            </span>
        </v-footer>
    </v-app>
</template>
<script>
export default {
    computed: {},
    data() {
        return {
            numVersion: "1.0"
        };
    }
};
</script>
