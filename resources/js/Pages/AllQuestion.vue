<template>
    <Master>
        <div class="card">
                  <div class="card-header">
                      <span class="badge badge-danger">Need Fixed</span>
                      <span>Question</span>
                      <a href="" class="badge badge-warning float-end ms-1">Delete?</a>
                      <a href="" class="badge badge-danger float-end">Fixed?</a>
                  </div>
                  <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda dolorem vel tenetur maxime nobis voluptatem labore nemo deserunt nisi voluptas. Optio, fugit consectetur tenetur aliquam, ab veniam iste veritatis quaerat aperiam corrupti molestiae! Nobis temporibus pariatur dignissimos iure nam! Voluptate minus incidunt quis praesentium eum, commodi, adipisci perferendis qui sed tenetur ratione officiis a error unde nulla, voluptas dolor autem excepturi quidem nisi. Odit nobis ipsum nulla soluta, voluptates ducimus laborum nihil sit, ab quas ratione, expedita laudantium. In reprehenderit molestiae nemo ullam est officiis. Tenetur, sunt iste quae saepe ut laborum voluptatibus animi eius excepturi. Et aut doloremque dolores!</p>
                  </div>
                  <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center"> 
                      <div class="d-flex gap-3">
                        <div>
                          <i class="fa-regular fa-heart text-danger"></i> 
                          <small class="ms-1">4</small> 
                        </div>
                        <div>
                          <i class="fa-regular fa-comment text-success"></i>
                          <small class="ms-1">4</small>
                        </div>
                        <div>
                          <i class="fa-regular fa-star text-warning"></i>
                          <small class="ms-1">4</small>
                        </div>
                      </div>
                      <div class="d-flex gap-2">
                        <a href="" class="badge badge-dark">Android</a> 
                        <a href="" class="badge badge-dark">Web</a>
                      </div>
                      <div>
                        <a href="" class="btn btn-sm btn-outline-primary">View</a> 
                      </div>
                    </div>
                  </div>
                </div>
    </Master>
</template>
<script setup>
import Master from './Layout/Master.vue';
    defineOptions({
        name:'AllQuestion'
    });
</script>