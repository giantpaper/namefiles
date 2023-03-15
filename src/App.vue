<template>
  <header id="top">
    <RouterLink to="/"><img alt="logo" class="logo" src="@/assets/logo.svg"  width="389.632" height="80.656" /></RouterLink>
    <Search />
  </header>

  <RouterView />
  <Footer />
</template>

<style scoped lang="scss">
  #top {
    background: #ddd;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    .logo {
      width: auto;
      max-height: 3rem;
    }
    & > a:hover {
      background: none;
    }
  }
</style>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Footer from './components/Footer.vue'
import Search from './components/Search.vue'
</script>
