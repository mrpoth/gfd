const removeFromLists = {
  methods: {
    removeFromList(game, collectionOption, index) {
      axios
        .post("http://localhost:8000/game/remove", {
          game: game,
          collectionOption: collectionOption,
        })
        .then((res) => {
          console.log(res);
          this.$delete(this.games, index);
          if (res.data.error) {
            console.log(res.data.error);
            this.error = res.data.error;
            alert(this.error);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};

export default removeFromLists;
