@extends('layouts.app')

@section('content')
<main>

    @component('components.bread-crumbs', ['crumbs' =>
    [
    'home' => '/',
    'about' => route('about')
    ]
    ])
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-2 mb-2">About</h1>
                <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, placeat.</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem ratione non, dicta repellat odio a
                    harum, magni tempora sit cupiditate odit recusandae nulla quibusdam sed! Earum animi cumque
                    perspiciatis. Sint.</p>
                <p>Voluptatum laborum sunt, consequuntur in assumenda quas amet sint debitis quam et facilis consequatur
                    ad eum libero saepe esse voluptatibus cupiditate. Harum aliquam asperiores dolorum totam et magnam
                    modi optio!</p>
                <p>Illo, cupiditate. Itaque debitis excepturi, esse totam quisquam quo vero cum assumenda sequi numquam.
                    Reiciendis voluptates ad dolore, atque tenetur distinctio, aspernatur enim ipsam id hic rem quia
                    delectus doloribus!</p>
                <p>Harum nostrum molestias veniam numquam quod, beatae suscipit autem exercitationem esse minus et non
                    deserunt aut. Iste harum consequatur nisi officia quod a quasi est recusandae ipsa dolore? Nesciunt,
                    voluptatibus.</p>
                <br>
                <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, placeat.</h4>
                <p>Cumque esse aliquam sapiente adipisci officiis molestiae! Obcaecati officiis tempora optio
                    necessitatibus repudiandae illum perspiciatis quas. Est omnis laudantium animi tenetur
                    necessitatibus! Illo harum officia accusantium expedita id possimus rerum.</p>
                <p>Assumenda, est quae cumque harum debitis suscipit accusantium saepe, rem commodi recusandae a nostrum
                    voluptas voluptate, consectetur laudantium numquam deleniti laboriosam nemo et! Eos, inventore.
                    Nulla natus suscipit animi quo?</p>
            </div>
        </div>
    </div>
</main>
@endsection