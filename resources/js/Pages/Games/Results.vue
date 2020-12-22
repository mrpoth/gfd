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
        <button class="add-to-collection">
          Add to
          <button
            @click="addToList(search_game, 'wishlist')"
            class="collection-options"
          >
            Wishlist
          </button>
          <button @click="addToList(search_game)" class="collection-options">
            Library
          </button>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import addToLists from "../../Mixins/addToLists";

export default {
  mixins: [addToLists],
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
