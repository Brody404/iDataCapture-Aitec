        <!-- Plugins css-->
        <link href="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />

                                    <div class="tags-default">
                                        <input type="text" value="Amsterdam,Washington,Sydney" data-role="tagsinput" placeholder="add tags"/>
                                    </div>

                                    <h5 class="m-t-40"><b>True multi value</b></h5>
                                    <p class="text-muted m-b-20 font-13">
                                        Use a <code>&lt;select multiple /&gt;</code> as your input element for a tags input, to gain true multivalue support.
                                        Instead of a comma separated string, the values will be set in an array. Existing <code>&lt;option /&gt;</code>
                                        elements will automatically be set as tags. This makes it also possible to create tags containing a comma.
                                    </p>
                                    <div class="m-b-0">
                                        <select multiple data-role="tagsinput">
                                            <option value="Amsterdam">Amsterdam</option>
                                            <option value="Washington">Washington</option>
                                            <option value="Sydney">Sydney</option>
                                        </select>
                                    </div>
