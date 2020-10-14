<template>
  <div class="card px-3">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="media">
              <img
                width="50"
                height="50"
                class="mr-3 rounded-circle"
                alt="Bootstrap Media Preview"
                src="https://i.imgur.com/stD0Q19.jpg"
              />
              <div class="media-body">
                <div class="row">
                  <div class="col-8 d-flex pb-0">
                    <h5>{{ commentData.user.name }}</h5>
                    <!-- <span>- 2 hours ago</span> -->
                  </div>
                  <div class="col-4 pb-0">
                    <div
                      class="pull-right reply"
                      v-if="userData.id == commentData.user.id"
                    >
                      <a
                        href=""
                        data-toggle="modal"
                        :data-target="'#comment' + commentData.id"
                        :id="commentData.id"
                        ><span><i class="fa fa-edit"></i> </span
                      ></a>
                      <a href="" class="" @click.prevent="deleteComment(commentData.id)"
                        ><span><i class="fa fa-trash"></i> </span
                      ></a>
                    </div>
                  </div>
                </div>
                {{ commentData.content }} <br />
                <a @click="displayReplies(commentData.id)" class="card-link reply-btn"
                  ><i class="fa fa-reply"></i> reply</a
                >
                <div class="comment" v-if="showReply">
                  <form action="post">
                    <input
                      type="text"
                      name="comment"
                      id=""
                      class="form-control"
                      placeholder="Enter a reply"
                      v-model="reply"
                    />
                    <button
                      type="submit"
                      class="btn btn-info"
                      @click.prevent="sumbitReply(commentData.id)"
                    >
                      reply
                    </button>
                  </form>
                </div>
                <template v-if="showReply == true">
                  <reply
                    v-for="reply in replies"
                    :key="reply.id"
                    :replyData="reply"
                    :userData="userData"
                    @deletedReply="deleteReply"
                    @editMyReply="editdReplyData"
                  ></reply>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      :id="'comment' + commentData.id"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit comment</h5>
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
              <label class="">Reply</label>
              <input
                type="text"
                :name="commentData.user.name"
                v-model="commentEdited"
                :id="commentData.id"
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
              @click="editComment(commentData.id)"
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
  props: ["commentData", "userData", "postId"],
  data() {
    return {
      showReply: false,
      commentEdited: this.commentData.content,
      reply: "",
      replies: [],
    };
  },
  methods: {
    displayReplies(id) {
      this.showReply = !this.showReply;
      if (this.showReply == true) {
        axios
          .get("/comments/replies/" + id)
          .then((data) => {
            console.log(data.data.replies);
            this.replies = data.data.replies;
          })
          .catch((err) => {
            console.log(err.data);
            console.log(err.response.data.message);
          });
      }
    },
    editComment(commentId) {
      let comment = {
        content: this.commentEdited,
        user_id: this.userData.id,
        id: this.postId,
      };
      console.log(comment);
      axios
        .put("/comment/" + commentId, comment)
        .then((data) => {

        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
    deleteComment(commentId, event) {
      axios
        .delete("/comment/" + commentId)
        .then((data) => {
          this.$emit("deletedComment", commentId);
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
    sumbitReply(commentId) {
      let reply = {
        content: this.reply,
        user_id: this.userData.id,
        id: this.postId,
        comment_parent_id: commentId,
      };
      console.log(reply);
      axios
        .post("/comment", reply)
        .then((data) => {
          this.showReply = false;
          this.displayReplies(this.commentData.id);
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },deleteReply(value){
 let index = this.replies.findIndex((ele) => ele.id == value);
      this.replies.splice(index, 1);
    },editdReplyData(reply){
      //  let index = this.replies.find((ele) => ele.id == reply.replyId);
      // this.replies.splice(index, 1);
      console.log(reply)
      this.replies.forEach(ele =>{
        if(ele.id == reply.replyId){
          ele.content=reply.content
        }
      })
    }
  },
};
</script>
<style lang="scss" >
@import '../../sass/_variables.scss';
.reply-btn{
  color:$main-color
}
.card-link:hover {
  cursor: pointer;
}
</style>