<div class="modal fade" id="media-{{$p->id}}">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <div class="imgUp float-right">
                                    <label class="btn-sm mb-0 btn-primary">Add Image<input type="file" class="uploadFile" name="gall_img[]" modal-id="{{$p->id}}" style="width: 0px;height: 0px;overflow: hidden;" multiple>
                                    </label>
                                </div>
                              </div>
                              <div class="modal-body gallery">
                              <div class="row added_img added_img{{$p->id}}">
                                  @foreach($pro_media as $m)
                                  @if($m->project_id == $p->id)
                                  <div class="col-sm-3 added">
                                      <img src="{{asset('images/projects').'/'.($m->image)}}" class="img-fluid mb-2" alt="white sample">
                                      <i class="fa fa-times del m_{{$m->id}}" pro_img_attr="{{$m->id}}"></i>
                                  </div> 
                                  @endif           
                                  @endforeach
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        # put this script after loop
                        <script type="text/javascript">
                          $(document).ready(function() {
                            $(document).on('change','.uploadFile',function(){
                              $.ajaxSetup({
                                headers: {
                                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                              });
                              var id = $(this).attr('modal-id');
                              var image_upload = new FormData();
                              var TotalImages = $(this)[0].files.length; //Total Images
                              var images = $(this)[0];
                              for (var i = 0; i < TotalImages; i++) {
                                image_upload.append('images' + i, images.files[i]);
                              }
                              image_upload.append('TotalImages', TotalImages);
                              $.ajax({  
                                url: "{{url('admin/add_project_media')}}/"+id,  
                                type: "POST",  
                                contentType: false,
                                processData: false,
                                data: image_upload,
                                success: function (result) {
                                  $('.added_img'+id).html();
                                  $('.added_img'+id).html(result['all']);
                                  $('.img-ref'+id).html(result['single']);
                                }  
                              });
                            });

                            $(document).on('click',".del",function(){
                              $(this).parent('.added').remove();
                            });
                            $(document).on('click',".del",function(){
                              var product_image_id=$(this).attr('pro_img_attr');                
                              $.ajax({
                                url:"{{url('/admin/remove_project_media')}}/"+product_image_id,
                                type: 'POST',
                                data: {
                                  "_token": "{{ csrf_token() }}",
                                },
                                success:function(data) {
                                }
                              });
                            });

                          });
                        </script>
