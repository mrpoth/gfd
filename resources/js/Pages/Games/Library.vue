<template>
  <div>
    <div class="collection-container">
      <div
        class="flex-single"
        v-for="library_game in library_games"
        :key="library_game.id"
      >
          <h3>{{ library_game.name }}</h3>
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
    library_games: Array,
  },
  methods: {
    replaceThumbWithBiggerImage(url) {
      return url.replace("thumb", "cover_big");
    },
    formatDate(date) {
      let properDate = new Date(date);
      return properDate.toLocaleDateString();
    },
  },
};
</script>
