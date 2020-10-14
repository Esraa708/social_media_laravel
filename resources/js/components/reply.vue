<template>
  <div class="media mt-4">
    <a class="pr-3" href="#"
      ><img
        width="50"
        height="50"
        class="rounded-circle"
        alt="Bootstrap Media Another Preview"
        src="https://i.imgur.com/xELPaag.jpg"
    /></a>
    <div class="media-body">
      <div class="row">
        <div class="col-8 d-flex">
          <h5>{{ replyData.user.name }}</h5>
        </div>
        <div class="col-4">
        <div class="pull-right reply" v-if="replyData.user.id == userData.id">
          <a
            href=""
            data-toggle="modal"
            :data-target="'#reply' + replyData.id"
            :id="replyData.id"
            ><span><i class="fa fa-edit"></i> </span
          ></a>
          <a href="" @click.prevent="deleteReply(replyData.id)"
            ><span><i class="fa fa-trash"></i> </span
          ></a>
        </div>
        </div>
      </div>
      {{ replyData.content }}
    </div>
    <div
      class="modal fade"
      :id="'reply' + replyData.id"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit reply</h5>
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
                :name="replyData.user.name"
                v-model="replyEdited"
                :id="replyData.id"
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
              @click="editReply(replyData.id)"
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
<style lang="scss" ></style>
<script>
export default {
  props: ["replyData", "userData"],
  data() {
    return {
      replyEdited: this.replyData.content,
    };
  },
  methods: {
    editReply(replyId) {
      let reply = {
        content: this.replyEdited,
        user_id: this.userData.id,
        id: this.replyData.post_id,
      };
      console.log(reply);
      axios
        .put("/comment/" + replyId, reply)
        .then((data) => {
          this.$emit("editMyReply", {
            replyId: replyId,
            content: this.replyEdited,
          });
        })
        .catch((err) => {
          po;
          console.log(err.data);
          x;
          console.log(err.response.data.message);
        });
    },
    deleteReply(replyId, event) {
      axios
        .delete("/comment/" + replyId)
        .then((data) => {
          this.$emit("deletedReply", replyId);
        })
        .catch((err) => {
          console.log(err.data);
          console.log(err.response.data.message);
        });
    },
  },
};
</script>