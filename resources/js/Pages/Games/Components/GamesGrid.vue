<template>
  <div>
    <div class="collection-grid">
      <div class="flex-single" v-for="(game, index) in games" :key="game.id">
        <img v-if="game.cover_url" :src="game.cover_url" />
        <img
          width="90"
          height="90"
          v-else
          src="https://cdn.pixabay.com/photo/2020/08/04/18/58/controller-5463628__340.png"
        />
        <a :href="`/game/${game.slug}`">
          <h3>{{ game.name }}</h3>
        </a>
        <button
          class="remove-from-collection"
          @click="removeFromList(game, collectionOption, index)"
        >
          Remove
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import removeFromLists from "../../../Mixins/removeFromLists";

export default {
  mixins: [removeFromLists],
  name: "GamesGrid",
  props: {
    games: Array,
    collectionOption: String,
  },
  data() {
    return {
      disabled: false,
    };
  },
};
</script>