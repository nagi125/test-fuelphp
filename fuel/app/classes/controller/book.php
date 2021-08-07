<?php
class Controller_Book extends Controller_Template
{

	public function action_index()
	{
		$data['books'] = Model_Book::find('all');
		$this->template->title = "Books";
		$this->template->content = View::forge('book/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('book');

		if ( ! $data['book'] = Model_Book::find($id))
		{
			Session::set_flash('error', 'Could not find book #'.$id);
			Response::redirect('book');
		}

		$this->template->title = "Book";
		$this->template->content = View::forge('book/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Book::validate('create');

			if ($val->run())
			{
				$book = Model_Book::forge(array(
					'name' => Input::post('name'),
					'price' => Input::post('price'),
					'description' => Input::post('description'),
				));

				if ($book and $book->save())
				{
					Session::set_flash('success', 'Added book #'.$book->id.'.');

					Response::redirect('book');
				}

				else
				{
					Session::set_flash('error', 'Could not save book.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Books";
		$this->template->content = View::forge('book/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('book');

		if ( ! $book = Model_Book::find($id))
		{
			Session::set_flash('error', 'Could not find book #'.$id);
			Response::redirect('book');
		}

		$val = Model_Book::validate('edit');

		if ($val->run())
		{
			$book->name = Input::post('name');
			$book->price = Input::post('price');
			$book->description = Input::post('description');

			if ($book->save())
			{
				Session::set_flash('success', 'Updated book #' . $id);

				Response::redirect('book');
			}

			else
			{
				Session::set_flash('error', 'Could not update book #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$book->name = $val->validated('name');
				$book->price = $val->validated('price');
				$book->description = $val->validated('description');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('book', $book, false);
		}

		$this->template->title = "Books";
		$this->template->content = View::forge('book/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('book');

		if ($book = Model_Book::find($id))
		{
			$book->delete();

			Session::set_flash('success', 'Deleted book #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete book #'.$id);
		}

		Response::redirect('book');

	}

}
