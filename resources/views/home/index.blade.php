@extends('home.home_master')
@section('home')
    @include('home.homelayout.slider')

    <!-- end hero -->
    @include('home.homelayout.features')
    <!-- end content -->

    @include('home.homelayout.clarifies')
    <!-- end content -->

    @include('home.homelayout.get_all')


    <div class="lonyo-content-shape3">
        <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
    </div>
    <!-- end content -->

    @include('home.homelayout.usability')


    <div class="lonyo-content-shape1">
        <img src="{{ asset('frontend/assets/images/shape/shape3.svg') }}" alt="">
    </div>
    <!-- end video -->

    @include('home.homelayout.review')
    <!-- end testimonial -->


    @include('home.homelayout.answer')

    <div class="lonyo-content-shape3">
        <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
    </div>
    <!-- end faq -->

    @include('home.homelayout.apps')
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            const titleElement = document.getElementById("slider-title");
            const descriptionsElement = document.getElementById("slider-descriptions");

            function saveChanges(element) {
                let sliderId = element.dataset.id;
                let field = element.id === "slider-title" ? "title" : "descriptions";
                let newValue = element.innerText.trim();

                fetch(`/edit-slider/${sliderId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content"),
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            [field]: newValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(`${field} updated successfully`);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            titleElement.addEventListener("blur", () => saveChanges(titleElement));
            descriptionsElement.addEventListener("blur", () => saveChanges(descriptionsElement));

            [titleElement, descriptionsElement].forEach(el => {
                el.addEventListener("keydown", function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        saveChanges(el);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            const featureTitleElement = document.getElementById("features-title");

            function saveFeatureTitleChanges(element) {
                let featureId = element.dataset.id;
                let field = element.id === "features-title" ? "features" : "";
                let newValue = element.innerText.trim();

                fetch(`/edit-features/${featureId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content"),
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            [field]: newValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(`${field} updated successfully`);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            featureTitleElement.addEventListener("blur", () => saveFeatureTitleChanges(featureTitleElement));

            featureTitleElement.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    saveFeatureTitleChanges(e.target);
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            const reviewTitleElement = document.getElementById("review-title");

            function saveReviewTitleChanges(element) {
                let reviewsId = element.dataset.id;
                let field = element.id === "review-title" ? "reviews" : "";
                let newValue = element.innerText.trim();

                fetch(`/edit-reviews/${reviewsId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content"),
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            [field]: newValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(`${field} updated successfully`);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            reviewTitleElement.addEventListener("blur", () => saveReviewTitleChanges(reviewTitleElement));

            reviewTitleElement.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    saveFeatureTitleChanges(e.target);
                }
            });
        });
    </script>


<script type="text/javascript">
        $(document).ready(function() {
            const answerTitleElement = document.getElementById("answer-title");

            function saveAnswerTitleChanges(element) {
                let answersId = element.dataset.id;
                let field = element.id === "answer-title" ? "answers" : "";
                let newValue = element.innerText.trim();

                fetch(`/edit-answers/${answersId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content"),
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            [field]: newValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(`${field} updated successfully`);
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }

            answerTitleElement.addEventListener("blur", () => saveAnswerTitleChanges(answerTitleElement));

            answerTitleElement.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    saveFeatureTitleChanges(e.target);
                }
            });
        });
    </script>



@endsection
