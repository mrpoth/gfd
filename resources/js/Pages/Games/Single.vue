<template>
  <div>
    <div class="flex-container">
      <div class="flex-single">
        <img
          v-if="game.cover"
          :src="replaceThumbWithBiggerImage(game.cover.url)"
          v-cosha
        />
        <img
          v-else
          src="https://cdn.pixabay.com/photo/2020/08/04/18/58/controller-5463628__340.png"
        />
        <h2>{{ game.name }}</h2>
        <p v-if="game.rating">
          Rating: {{ Math.round(game.aggregated_rating) }} ({{
            game.aggregated_rating_count
          }}
          votes)
        </p>
        <p v-else>No ratings yet</p>
        <p v-for="genre in game.genres" :key="genre.id">
          {{ genre.name }}
        </p>
        <h3>Release Date: {{ formatDate(game.first_release_date) }}</h3>
        <p>{{ game.summary }}</p>
        <button class="add-to-collection">
          Add to
          <button
            @click="addToList(game, 'wishlist')"
            class="collection-options"
          >
            Wishlist
          </button>
          <button
            @click="addToList(game, 'library')"
            class="collection-options"
          >
            Library
          </button>
        </button>
        <div class="collection-container" v-if="game.similar_games">
          <h3>Similar Games</h3>
          <div
            class="collection-single"
            v-for="similar_game in game.similar_games"
            :key="similar_game.id"
          >
            <a :href="similar_game.slug">{{ similar_game.name }}</a>
            <button class="add-to-collection">
              Add to
              <button
                @click="addToList(similar_game, 'wishlist')"
                class="collection-options"
              >
                Wishlist
              </button>
              <button
                @click="addToList(similar_game, 'library')"
                class="collection-options"
              >
                Library
              </button>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import addToLists from "../../Mixins/addToLists";
import removeFromLists from "../../Mixins/removeFromLists";

export default {
  mixins: [addToLists, removeFromLists],
  data() {
    return {
      error: "",
    };
  },
  props: {
    game: Object,
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
