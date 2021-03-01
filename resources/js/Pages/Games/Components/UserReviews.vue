<template>
  <div>
      <input type="textarea" disabled :value="review">
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "UserReviews",
  props: {
    review: String,
    game_id: Number
  },
  methods: {
      getReviews() {
          axios.get('/review', {
              params: {
                game_id: this.game_id,
              }
          }).then(res => {
              console.log(res.data);
              this.review = res.data
          })
      },
  },
  mounted() {
      this.getReviews()
  }
};
</script>