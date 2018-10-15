<template>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" class="navbar-item">
                    <strong>Youpeng</strong>
                </router-link>
                <div class="navbar-burger burger" :class="{ 'is-active': isActive }" @click="isActive = !isActive">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div><!-- navbar brand -->

            <div class="navbar-menu" :class="{ 'is-active': isActive }">
                <div v-if="$_auth.check" class="navbar-start">
                    <router-link to="/" class="navbar-item">
                        <span>Timeline</span>
                    </router-link>
                    <router-link to="/friends" class="navbar-item">
                        <span>Friends</span>
                    </router-link>
                    <div class="navbar-item">
                        <search-form ></search-form>
                    </div>
                </div><!-- navbar start -->   

                <div class="navbar-end">
                    <router-link v-if="$_auth.check" :to="profile($_auth.user)" class="navbar-item">
                        {{ $_auth.user.firstname }} {{ $_auth.user.lastname }}
                    </router-link>

                    <template v-if="$_auth.guest">
                        <router-link to="/signup" class="navbar-item">
                            Sign up
                        </router-link>
                        <router-link to="/signin" class="navbar-item">
                            Sign in
                        </router-link>
                    </template>

                    <div v-if="$_auth.check" class="navbar-item has-dropdown is-hoverable">
                        <a  class="navbar-link" href="#"></a>
                        <div class="navbar-dropdown is-right">
                                <router-link to="/profile/edit" class="navbar-item">
                                    Update profile
                                </router-link>
                                <router-link to="/password/change" class="navbar-item">
                                    Change password
                                </router-link>
                                <hr class="navbar-divider">
                                <a class="navbar-item" @click="onClickSignout">
                                    Sign out
                                </a> 
                        </div><!-- navbar-dropdown -->
                    </div><!-- navbar-item has-dropdwon -->
                </div><!-- navbar-end -->
            </div><!-- navbar-menu -->
        </div><!-- container -->
    </nav>
</template>

<script>
import SearchForm from './SearchForm';
import { profile } from '../../util/mixins';

export default {
    components: { SearchForm },
    mixins:[profile],
    data () {
        return {
            isActive: false
        };
    },
    methods: {
        onClickSignout () {
            this.$http.post('/api/logout')
                .then((Response) => {
                    this.$store.dispatch('logout');
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        }
    }
}
</script>

<style scoped>

</style>


