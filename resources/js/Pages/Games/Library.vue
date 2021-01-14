<template>
  <div>
    <GamesGrid
      v-bind:games="library_games"
      v-bind:collectionOption="'library'"
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
    library_games: Array,
  },
};
</script>
