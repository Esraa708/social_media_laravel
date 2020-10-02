<template>
  <div class="container">
    <div class="row mb-3">
      <div class="col-12">
        <!--- \\\\\\\Post-->
        <div class="card gedf-card w-2">
          <div class="card-header">
            <h3>What is on your mind??</h3>
            <!-- <ul
                            class="nav nav-tabs card-header-tabs"
                            id="myTab"
                            role="tablist"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    id="posts-tab"
                                    data-toggle="tab"
                                    href="#posts"
                                    role="tab"
                                    aria-controls="posts"
                                    aria-selected="true"
                                    >Make a publication</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    id="images-tab"
                                    data-toggle="tab"
                                    role="tab"
                                    aria-controls="images"
                                    aria-selected="false"
                                    href="#images"
                                    >Images</a
                                >
                            </li>
                        </ul>-->
          </div>
          <div class="card-body">
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active"
                id="posts"
                role="tabpanel"
                aria-labelledby="posts-tab"
              >
                <div class="form-group">
                  <label class="sr-only" for="message">Post Title</label>
                  <input
                    type="text"
                    name="title"
                    id=""
                    placeholder="Post title"
                    class="form-control"
                    v-model="title"
                  />
                </div>
                <div class="form-group">
                  <label class="sr-only" for="message">post</label>
                  <textarea
                    class="form-control"
                    id="message"
                    rows="3"
                    placeholder="What are you thinking?"
                    v-model="content"
                  ></textarea>
                </div>
              </div>
            </div>
            <div class="btn-toolbar justify-content-between">
              <div class="btn-group">
                <div class="element">
                  <!-- <i class="fa fa-camera"></i -->
                  <!-- ><span class="name">No file selected</span> -->
                  <input
                    type="file"
                    @change="uploadFiles($event)"
                    multiple
                    name=""
                    id=""
                  />
                </div>
              </div>
              <div class="btn-group">
                <button
                  type="submit"
                  class="btn btn-primary"
                  @click.prevent="addPost()"
                >
                  share
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div v-for="post in posts" :key="post.id">
          <single-post
            :postData="post"
            :userData="user"
            @deletedPost="deletePost"
            @editPost="editPost"
          ></single-post>
        </div>
        <infinite-loading
          @distance="1"
          force-use-infinite-wrapper
          @infinite="infiniteHandler"
        ></infinite-loading>
      </div>
    </div>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :color="color"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false">Close</v-btn>
      </template>
    </v-snackbar>
  </div>
</template>
<style lang="css" scoped>
.element {
  display: inline-flex;
  align-items: center;
}
i.fa-camera {
  margin: 10px;
  cursor: pointer;
  font-size: 30px;
}
i:hover {
  opacity: 0.6;
}
input[type="file"] {
  display: block;
  /* visibility: hidden; */
}
</style>
<script>
export default {
  mounted() {
    // this. getPosts()
  },
  props: ["user"],
  data() {
    return {
      title: "",
      content: "",
      images: "",
      color: "",
      mode: "success",
      snackbar: false,
      text: "",
      timeout: 6000,
      x: null,
      y: "top",
      posts: [],
      page: 1,
    };
  },
  methods: {
    uploadFiles(e) {
      let files = e.target.files;
      this.images = files;
    },
    addPost() {
      let formData = new FormData();
      for (let i = 0; i < this.images.length; i++) {
        let file = this.images[i];
        console.log("files[" + i + "]");
        formData.append("files[" + i + "]", file);
      }
      formData.append("title", this.title);
      formData.append("content", this.content);

      axios
        .post("/post", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          // console.log(res.data.post),
          this.posts.unshift(res.data.post);
          console.log(res.data);
          this.page = this.page + 1;
          this.color = "#2E7D32";
          this.text = res.data.message;
          this.snackbar = true;
          this.friendMail = "";
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
          this.color = "#C62828";
          this.text = err.response.data.message;
          this.snackbar = true;
        });
    },
    getPosts() {
      axios
        .get("/post")
        .then((res) => {
          console.log(res);
          this.color = "#2E7D32";
          this.text = res.data.message;
          this.snackbar = true;
          this.friendMail = "";
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
          this.color = "#C62828";
          this.text = err.response.data.message;
          this.snackbar = true;
        });
    },
    infiniteHandler($state) {
      console.log($state);
      axios
        .get("/post", {
          params: {
            page: this.page,
          },
        })
        .then(({ data }) => {
          console.log(data);
          if (data.posts.data.length) {
            this.page += 1;
            this.posts.push(...data.posts.data);
            $state.loaded();
          } else {
            $state.complete();
          }
        });
    },
    editPost(post) {
      console.log(post);
      this.posts.forEach((ele) => {
        if (ele.id == post.postId) {
          ele.post_content = post.content;
           ele.post_title = post.title;
        }
      });
    },
    deletePost(value) {
      console.log(value);
      let index = this.posts.findIndex((ele) => ele.id == value);

      this.posts.splice(index, 1);
    },
  },
};
</script>
