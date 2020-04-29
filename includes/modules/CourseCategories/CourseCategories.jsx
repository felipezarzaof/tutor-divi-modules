// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseCategories extends Component {

    static slug = 'tutor_course_categories';

    render() {
        return (
            <Fragment>
                <div 
                    dangerouslySetInnerHTML={{ __html: this.props.__categories }} 
                />
            </Fragment>
        );
    }
}

export default CourseCategories;