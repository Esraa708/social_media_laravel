<template>
  <div class="card gedf-card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center">
          <div class="mr-2">
            <img
              class="rounded-circle"                                                                                  
              width="45"
              src="https://picsum.photos/50/50"
              alt=""
            />
          </div>
          <div class="ml-2">
            <div class="h5 m-0">{{ postData.user.name }}</div>
            <!-- <div class="h7 text-muted">Miracles Lee Cross</div> -->
          </div>
        </div>
        <div>
          <div class="pull-right reply" v-if="postData.user.id == userData.id">
            <a
              href=""
              data-toggle="modal"
              :data-target="'#post' + postData.id"
              :id="postData.id"
              ><span><i class="fa fa-edit"></i> </span
            ></a>
            <a href="" @click.prevent="deletePost(postData.id)"
              ><span><i class="fa fa-trash"></i> </span
            ></a>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="text-muted h7 mb-2">
        <!-- <i class="fa fa-clock-o"></i>10 min ago -->
      </div>
      <a class="card-link" href="#">
        <h5 class="card-title">
          {{ postData.post_title }}
        </h5>
      </a>

      <p class="card-text">
        {{ postData.post_content }}
      </p>
    </div>
    <div class="card-footer">
      <a @click="displayComments(postData.id)" class="card-link"
        ><i class="fa fa-comment"></i> Comment</a
      >
    </div>
    <div class="comment" v-if="commentShow == true">
      <form action="post" method="">
        <input
          type="text"
          name="comment"
          class="form-control"
          placeholder="Enter a comment"
          v-model="content"
        />
        <button
          type="submit"
          class="btn btn-info"
          @click.prevent="sumbitComment(postData.id)"
        >
          comment
        </button>
      </form>
    </div>
    <template v-if="commentShow == true">
      <comment
        v-for="comment in comments"
        :key="comment.id"
        :commentData="comment"
        :userData="userData"
        :postId="postData.id"
        @deletedComment="deleteComment"
      ></comment>
    </template>

    <div
      class="modal fade"
      :id="'post' + postData.id"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit post</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">title</label>
              <input
                type="text"
                name="title"
                v-model="EditedpostTitle"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label class="">Content</label>
              <input
                type="text"
                :name="postData.user.name"
                v-model="postEdited"
                :id="postData.id"
                class="form-control"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="editPost(postData.id)"
              data-dismiss="modal"
            >
              Save changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    // console.log(this.postData)
  },
  props: ['postData', 'userData'],
  data() {
    return {
      commentShow: false,
      comments: [],
      content: "",
      dialog: false,
      postEdited: this.postData.post_content,
      EditedpostTitle: this.postData.post_title,
    };
  },
  methods: {
    displayComments(id) {
      this.commentShow = !this.commentShow;
      if (this.commentShow == true) {
        axios
          .get("/post/comments/" + id)
          .then((data) => {
            console.log(data.data.comments);
            this.comments = data.data.comments;
          })
          .catch((err) => {
            console.log(err.data);
            console.log(err.response.data.message);
          });
      }
    },
    sumbitComment(id) {
      let comment = {
        content: this.content,
        id: id,
      };
      axios
        .post("/comment", comment)
        .then((data) => {
           this.commentShow =false;
          this.displayComments(this.postData.id);
          
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
    editPost(postId) {
      let post = {
        title: this.EditedpostTitle,
        content: this.postEdited,
        user_id: this.userData.id,
      };
      console.log(post);
      axios
        .put("/post/" + postId, post)
        .then((data) => {
             this.$emit("editPost", {
            postId: postId,
            content: this.postEdited,
            title:this.EditedpostTitle
          });
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
    deletePost(postId) {
      axios
        .delete("/post/" + postId)
        .then((data) => {
            this.$emit("deletedPost", postId);
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
    deleteComment(value) {
      let index = this.comments.findIndex((ele) => ele.id == value);
      this.comments.splice(index, 1);
    },
  },
};
</script>
<style lang="css">
.card-link:hover {
  cursor: pointer;
}
.comment form {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
}
.pull-right.reply span:hover {
  cursor: pointer;
}
</style>
