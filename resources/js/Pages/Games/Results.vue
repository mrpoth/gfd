<template>
  <div>
    <div class="results-container">
      <div
        class="single-result"
        v-for="search_game in search_games"
        :key="search_game.id"
      >
        <a :href="`/game/${search_game.slug}`">
          <h3>{{ search_game.name }}</h3>
        </a>
         <AddToCollection v-bind:game="search_game" />

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AddToCollection from "../Games/Components/AddToCollection";

export default {
    components: {
    AddToCollection,
  },
  props: {
    search_games: Array,
  },
  methods: {
    formatDate(date) {
      let properDate = new Date(date);
      return properDate.toLocaleDateString();
    },
  },
};
</script>
