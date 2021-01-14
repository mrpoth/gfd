<template>
  <div>
    <h1>Recent Games</h1>
    <div class="games-grid">
      <div
        class="game-single"
        v-for="recent_game in recent_games"
        :key="recent_game.id"
      >
        <div v-if="recent_game.cover">
          <a :href="`/game/${recent_game.slug}`">
            <img
              :src="replaceThumbWithBiggerImage(recent_game.cover.url)"
              v-cosha
            />
          </a>
        </div>
        <div v-else>
          <a :href="`/game/${recent_game.slug}`">
            <img
              src="https://cdn.pixabay.com/photo/2020/08/04/18/58/controller-5463628__340.png"
            />
          </a>
        </div>
        <a :href="`/game/${recent_game.slug}`">
          <h3>{{ recent_game.name }}</h3>
        </a>
        <h4>({{ formatDate(recent_game.first_release_date) }})</h4>
        <button class="add-to-collection">
          Add to
          <button
            @click="addToList(recent_game, 'wishlist')"
            class="collection-options"
          >
            Wishlist
          </button>
          <button @click="addToList(recent_game)" class="collection-options">
            Library
          </button>
        </button>
        <p :id="recent_game.id">{{ tooltipMessage }}</p>
      </div>
    </div>
    <h1>Popular Games</h1>
    <div class="games-grid">
      <div
        class="game-single"
        v-for="popular_game in popular_games"
        :key="popular_game.id"
      >
        <div v-if="popular_game.cover">
          <a :href="`/game/${popular_game.slug}`">
            <img
              :src="replaceThumbWithBiggerImage(popular_game.cover.url)"
              v-cosha
            />
          </a>
        </div>
        <div v-else>
          <a :href="`/game/${popular_game.slug}`">
            <img
              src="https://cdn.pixabay.com/photo/2020/08/04/18/58/controller-5463628__340.png"
            />
          </a>
        </div>
        <a :href="`/game/${popular_game.slug}`">
          <h3>{{ popular_game.name }}</h3>
        </a>
        <button class="add-to-collection">
          Add to
          <button
            @click="addToList(popular_game, 'wishlist')"
            class="collection-options"
          >
            Wishlist
          </button>
          <button @click="addToList(popular_game)" class="collection-options">
            Library
          </button>
        </button>
        <p :id="popular_game.id">{{ tooltipMessage }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import addToLists from "../../Mixins/addToLists";

export default {
  mixins: [addToLists],
  data() {
    return {
      error: "",
      tooltipMessage: "",
    };
  },
  props: {
    recent_games: Array,
    popular_games: Array,
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
