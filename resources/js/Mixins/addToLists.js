const addToLists = {
    methods: {
        addToList(game, collectionOption) {
            axios
                .post("http://localhost:8000/game/store", {
                    game: game,
                    collectionOption: collectionOption
                })
                .then((res) => {
                    console.log(res.data);
                    if (res.data.error) {
                        console.log(res.data.error)
                        this.error = res.data.error
                        alert(this.error);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};

export default addToLists;
