<template>
  <div>
    <div class="flex-container">
      <div class="flex-single">
        <img
          v-if="game.data.cover"
          :src="replaceThumbWithBiggerImage(game.data.cover.url)"
          v-cosha
        />
        <img
          v-else
          src="https://cdn.pixabay.com/photo/2020/08/04/18/58/controller-5463628__340.png"
        />
        <h2>{{ game.data.name }}</h2>
        <p v-if="game.data.rating">
          Rating: {{ Math.round(game.data.aggregated_rating) }} ({{
            game.data.aggregated_rating_count
          }}
          votes)
        </p>
        <p v-else>No ratings yet</p>
        <p v-for="genre in game.data.genres" :key="genre.id">
          {{ genre.name }}
        </p>
        <h3>Release Date: {{ formatDate(game.first_release_date) }}</h3>
        <p>{{ game.data.summary }}</p>
        <AddToCollection v-bind:game="game" />
        <div class="collection-container" v-if="game.data.similar_games">
          <h3>Similar Games</h3>
          <div
            class="collection-single"
            v-for="similar_game in game.data.similar_games"
            :key="similar_game.id"
          >
            <a :href="similar_game.slug">{{ similar_game.name }}</a>
            <AddToCollection v-bind:game="similar_game" />
          </div>
        </div>
        <div id="review-form">
          <textarea v-model="review" rows="10" class="w-full">
          </textarea>
          <button @click="submitReview">
            Submit
          </button>
        </div>
        <div id="reviews">
          <p v-for="review in reviews" :key="review.id">
            {{ review.body }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import removeFromLists from "../../Mixins/removeFromLists";
import AddToCollection from "../Games/Components/AddToCollection";

export default {
    components: {
    AddToCollection,
  },
  mixins: [ removeFromLists],
  data() {
    return {
      error: "",
      reviews: [],
      review: ''
    };
  },
  props: {
    game: Object,
  },
  created() {
    console.log(this.game);

    this.getReviews();
  },
  methods: {
    async getReviews() {
      const {data} = await axios.get(`/game/${this.game.id}/reviews`);

      this.reviews = data;

      console.log(data);
    },
    async submitReview() {
      await axios.post(`/game/${this.game.id}/reviews`, {
        body: this.review
      });

      await this.getReviews();
    },
    // API only returns thumbnails, have to text-replace for different sizes
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
