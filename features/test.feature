Feature: Test the Instant Articles generators

    Background:
        When I am on "/uncategorized/test-html/6/instant-articles"

    Scenario: It will have a header
        Then the response should contain "<h1>Hello Headline</h1>"

    Scenario: It will have a standfirst
        Then the response should contain "<i>Hello standfirst</i>"

    Scenario: It will have an embed widget
        Then the response should contain "<iframe src=\"https://www.youtube.com/embed/G7RgN9ijwE4?rel=0&amp;showinfo=0\" style=\"border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;\" allowfullscreen scrolling=\"no\">"

    Scenario: It will have an Gallery widget
        Then the response should contain "<h1>350x150</h1>"
        And  the response should contain "<img src=\"http://shortlist.dev/app/uploads/2017/09/350x150-218.png\"/>"

    Scenario: It will have a heading widget
        Then the response should contain "<h1>Hello Instant Articles</h1>"

    Scenario: It will have a html widget
        Then the response should contain "<iframe class=\"no-margin\"><div><p>Hello Instant Articles</p></div></iframe>"

    Scenario: It will have a paragraph widget
        Then the response should contain "<p>Hello Paragraph</p>"

    Scenario: It will have a pull quote widget
        Then the response should contain "<blockquote><i>&ldquo;Hello Quote&rdquo;</i></blockquote>"

    Scenario: It will have a image widget
        Then the response should contain "<img src=\"http://shortlist.dev/app/uploads/2017/09/600x450-218.png\"/>"
        And the response should contain "<figcaption>Hello caption"
