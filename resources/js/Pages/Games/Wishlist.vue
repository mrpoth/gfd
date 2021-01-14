<template>
  <div>
    <GamesGrid
      v-bind:games="wishlist_games"
      v-bind:collectionOption="'wishlist'"
    />
  </div>
</template>

<script>
import axios from "axios";
import GamesGrid from "../Games/Components/GamesGrid";

export default {
  components: {
    GamesGrid,
  },
  props: {
    wishlist_games: Array,
  },
};
</script>
